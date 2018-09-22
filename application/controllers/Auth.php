<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	var $notificacion;
	var $notificacion_error;

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth','form_validation'));
		$this->load->helper(array('url','language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		$this->load->model( 'Ion_auth_model', '', TRUE );
		$this->load->model( 'M_operaciones', '', TRUE );
		$this->load->model( 'M_configuracion', '', TRUE );
		$this->load->model('upload_model');
	}

	// redirect if needed, otherwise display the user list
	public function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		}
		/*elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Ud. debe ser administrador para ver esta página.');
		}*/
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// Buscar el usuario actual
			$user = $this->ion_auth->user()->row();
			 $usuario_act= $user->id;
			 $group = array('Administradores'); 
			 if ($this->ion_auth->in_group($group))
			 {
				 // Buscar todos los subordinados
				$this->data['users'] = $this->Ion_auth_model->obt_allUser()->result();
			 }else{
				 // Buscar los subordinados del usuario actual
				$this->data['users'] = $this->Ion_auth_model->obt_subordinados($usuario_act)->result();
			 }
			
			 

			//list the users
			//$this->data['users'] = $this->ion_auth->users()->result();
			foreach ($this->data['users'] as $k => $user)
			{	
				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
				
			}

			$this->load->view('lte_header');
			$this->_render_page('auth/index', $this->data);
			$this->load->view('lte_footer');
		}
	}

	// log the user in
	public function login()
	{
		$this->data['title'] = $this->lang->line('login_heading');

		//validate form input
		$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

		if ($this->form_validation->run() == true)
		{
			$data = array(
				'filtro1' => '1',
				'filtro2' => '',
				'filtro3' => '',
				'filtro4' => '',
				'filtro5' => '',
				'filtro6' => '',
				'filtro7' => '',
				'vencido' => '',
				'inactivo' => '',
				'anno' => '2018',
				'mes' => '1',
				'fil_nombre' => '',
				'fil_telefono' => '',
				'fil_dni' => '',
				'fil_email' => '',
				'fil_factura' => '',
				'fil_producto' => '',
				'fil_fecha' => '',
				'fil_baja' => '',	  
				'fil_mcoy' => '',	  
				'fil_vip' => ''	  
				);		
				
			$this->session->set_userdata($data);
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool) $this->input->post('remember');

			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
			{
				//if the login is successful
				//redirect them back to the home page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/', 'refresh');
			}
			else
			{
				// if the login was un-successful
				// redirect them back to the login page
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
			}
		}
		else
		{
			// the user is not logging in so display the login page
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['identity'] = array('name' => 'identity',
				'id'    => 'identity',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('identity'),
			);
			$this->data['password'] = array('name' => 'password',
				'id'   => 'password',
				'type' => 'password',
			);

			$this->_render_page('auth/login', $this->data);
		}
	}

	// log the user out
	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	// change password
	public function change_password()
	{
		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() == false)
		{
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id'   => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name'    => 'new',
				'id'      => 'new',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name'    => 'new_confirm',
				'id'      => 'new_confirm',
				'type'    => 'password',
				'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
			);
			$this->data['user_id'] = array(
				'name'  => 'user_id',
				'id'    => 'user_id',
				'type'  => 'hidden',
				'value' => $user->id,
			);

			// render
			$this->_render_page('auth/change_password', $this->data);
		}
		else
		{
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change)
			{
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	// forgot password
	public function forgot_password()
	{
		// setting validation rules by checking whether identity is username or email
		if($this->config->item('identity', 'ion_auth') != 'email' )
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		}
		else
		{
		   $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}


		if ($this->form_validation->run() == false)
		{
			$this->data['type'] = $this->config->item('identity','ion_auth');
			// setup the input
			$this->data['identity'] = array('name' => 'identity',
				'id' => 'identity',
			);

			if ( $this->config->item('identity', 'ion_auth') != 'email' ){
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			}
			else
			{
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('auth/forgot_password', $this->data);
		}
		else
		{
			$identity_column = $this->config->item('identity','ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

			if(empty($identity)) {

	            		if($this->config->item('identity', 'ion_auth') != 'email')
		            	{
		            		$this->ion_auth->set_error('forgot_password_identity_not_found');
		            	}
		            	else
		            	{
		            	   $this->ion_auth->set_error('forgot_password_email_not_found');
		            	}

		                $this->session->set_flashdata('message', $this->ion_auth->errors());
                		redirect("auth/forgot_password", 'refresh');
            		}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten)
			{
				
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/forgot_password", 'refresh');
			}
		}
	}

	// reset password - final step for forgotten password
	public function reset_password($code = NULL)
	{
		if (!$code)
		{
			show_404();
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user)
		{
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

			if ($this->form_validation->run() == false)
			{
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
				$this->data['new_password'] = array(
					'name' => 'new',
					'id'   => 'new',
					'type' => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['new_password_confirm'] = array(
					'name'    => 'new_confirm',
					'id'      => 'new_confirm',
					'type'    => 'password',
					'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
				);
				$this->data['user_id'] = array(
					'name'  => 'user_id',
					'id'    => 'user_id',
					'type'  => 'hidden',
					'value' => $user->id,
				);
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('auth/reset_password', $this->data);
			}
			else
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
				{

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);

					show_error($this->lang->line('error_csrf'));

				}
				else
				{
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

					if ($change)
					{
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					}
					else
					{
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		}
		else
		{
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}


	// activate the user
	public function activate($id, $code=false)
	{
		if ($code !== false)
		{
			$activation = $this->ion_auth->activate($id, $code);
		}
		else if ($this->ion_auth->is_admin())
		{
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation)
		{
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		}
		else
		{
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/forgot_password", 'refresh');
		}
	}

	// deactivate the user
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() )
		{
			// redirect them to the home page because they must be an administrator to view this
			return show_error('Ud. debe ser administrador para ver esta página.');
		}

		$id = (int) $id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() == FALSE)
		{
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		}
		else
		{
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes')
			{
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
				{
					show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
				{
					$this->ion_auth->deactivate($id);
				}
				//quitar al usuario de revendedores y de subordinados		
				$res = $this->M_configuracion->eliminar_revendedor($id);
				$res = $this->M_configuracion->eliminar_de_subordinados($id);
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	// create a new user
	public function create_user()
    {
        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['company'] = array(
                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->load->view('lte_header');
			$this->_render_page('auth/create_user', $this->data);
			$this->load->view('lte_footer');
        }
    }

	// edit a user
	public function edit_user($id)
	{
		$foto = $this->upload_model->tomar_foto($id);
		if($foto != NULL)
		{
		$this->data['foto'] = $foto->ruta;	
		}else
			{
			$this->data['foto'] = "rodolfo.jpg";	
			}		
		
		$config['upload_path'] = 'uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2000';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';
		
		$this->load->library('upload', $config);
        
        if ($this->upload->do_upload()) {
			$file_info = $this->upload->data();
            $this->_create_thumbnail($file_info['file_name']);
			$data = array('upload_data' => $this->upload->data());
			$titulo = $this->input->post('first_name');
			$imagen = $file_info['file_name'];
			
            if($foto != NULL)
			{
			$this->upload_model->modificar($id,$titulo,$imagen);	
			}else
				{
				$this->upload_model->subir($id,$titulo,$imagen);	
				}			
			
        } 
		
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() )
		{
			redirect('auth', 'refresh');
		}
		$superiores = $this->Ion_auth_model->obt_superiores();
		$this->data['superiores'] = $superiores;
		$superior = $this->Ion_auth_model->obt_superior($id);
		$this->data['superior'] = $superior;	
		$user = $this->ion_auth->user($id)->row();
		$groups=$this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		$sup = $this->input->post('id_superior');
		if($sup >0){
			$act = $this->Ion_auth_model->act_superior($id,$sup);
		}
		
		

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

		if (isset($_POST) && !empty($_POST))
		{
			// do we have a valid request?
			/*if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
			{
				show_error($this->lang->line('error_csrf'));
			}
			print_r('prueba');die();*/
			// update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE)
			{
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'company'    => $this->input->post('company'),
					'phone'      => $this->input->post('phone'),
					'email'      => $this->input->post('email'),
				);

				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}



				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin())
				{
					//Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}

					}
				}

			// check to see if we are updating the user
			   if($this->ion_auth->update($user->id, $data))
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->messages() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('auth', 'refresh');
					}

			    }
			    else
			    {
			    	// redirect them back to the admin page if admin, or to the base url if non admin
				    $this->session->set_flashdata('message', $this->ion_auth->errors() );
				    if ($this->ion_auth->is_admin())
					{
						redirect('auth', 'refresh');
					}
					else
					{
						redirect('/', 'refresh');
					}

			    }

			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['email'] = array(
			'name'  => 'email',
			'id'    => 'email',
			'type'  => 'email',
			'value' => $this->form_validation->set_value('email', $user->email),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->load->view('lte_header');
		$this->_render_page('auth/edit_user', $this->data);
		$this->load->view('lte_footer');
		
	}

	// create a new group
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

		if ($this->form_validation->run() == TRUE)
		{
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if($new_group_id)
			{
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		}
		else
		{
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->load->view('lte_header');
			$this->_render_page('auth/create_group', $this->data);
			$this->load->view('lte_footer');
			
		}
	}

	// edit a group
	public function edit_group($id)
	{
		// bail if no group id given
		if(!$id || empty($id))
		{
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
		{
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST))
		{
			if ($this->form_validation->run() === TRUE)
			{
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if($group_update)
				{
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				}
				else
				{
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->load->view('lte_header');
		$this->_render_page('auth/edit_group', $this->data);
		$this->load->view('lte_footer');
		
	}


	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data: $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
	 // Interfaz para registrar un nuevo usuario
	public function nuevo_usuario()
	{		
		$datos['notificacion'] = "Especifique los datos del nuevo usuario:";
		$datos['modo_edicion'] = false;
		$datos['notificacion_error'] = $this->notificacion_error;
		
				
		$this->load->view('lte_header', $datos);
		$this->load->view('v_usuarios', $datos);
		$this->load->view('lte_footer', $datos);	
	}
		// Registrando un canal
    public function registrar_usuario()
    {
		 $nombre = $this->input->post('nombre');
         $apellidos = $this->input->post('apellidos');
         $empresa = $this->input->post('empresa');
         $telefono = $this->input->post('telefono');
		 $email = $this->input->post('email');
         $clave = $this->input->post('clave');
         $rclave = $this->input->post('rclave');

		 $Administradores 	= $this->input->post('Administradores');
		 $Miembros 			= $this->input->post('Miembros');
		 $Despachadores 	= $this->input->post('Despachadores');
		 $Revendedores		= $this->input->post('Revendedores');
		 $RevendedoresInt	= $this->input->post('RevendedoresInt');
		 $Consultores 		= $this->input->post('Consultores');
		 $ConsultorRV		= $this->input->post('ConsultorRV');
		 $ConsultorRVInt	= $this->input->post('ConsultorRVInt');
		 $Supervisores 		= $this->input->post('Supervisores');
		 $JefeArea 			= $this->input->post('JefeArea');
		 $ResponsableArmado = $this->input->post('ResponsableArmado');
		 $GerenteProduccion = $this->input->post('GerenteProduccion');


		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		 $this->form_validation->set_rules('empresa', 'Compañia', 'trim');
		 $this->form_validation->set_rules('email', 'email', 'required|valid_email');
		 $this->form_validation->set_rules('telefono', 'Teléfono', 'trim');
		 $this->form_validation->set_rules('clave', 'Contraseña', 'required|min_length[7]|max_length[15]|matches[rclave]');
		 $this->form_validation->set_rules('rclave', 'Confirmación de contraseña', 'required');

		 if ($this->form_validation->run() == true )
		 {		 
			
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2000';
			$config['max_width'] = '2024';
			$config['max_height'] = '2008';
			
			$email    = strtolower($this->input->post('email'));
            $identity = $email;
            $password = $this->input->post('clave');

            $additional_data = array(
                'first_name' => $this->input->post('nombre'),
                'last_name'  => $this->input->post('apellidos'),
                'company'    => $this->input->post('empresa'),
                'phone'      => $this->input->post('telefono'),
            );

			 //$registrado = $this->ion_auth->register($identity, $password, $email, $additional_data);
			 
			 $mensaje = "";
			 if ($this->ion_auth->register($identity, $password, $email, $additional_data))
				 { 
					 $this->notificacion = "Se ha registrado un nuevo usuario.";
		             $this->notificacion_error = false;

					 $id_usuario=$this->Ion_auth_model->obt_id_user($email);
					 if($Administradores) $this->ion_auth->add_to_group(1, $id_usuario);
					 if($Despachadores) $this->ion_auth->add_to_group(3, $id_usuario);
					 if($Revendedores) $this->ion_auth->add_to_group(4, $id_usuario);
					 if($RevendedoresInt) $this->ion_auth->add_to_group(11, $id_usuario);
					 if($Consultores) $this->ion_auth->add_to_group(5, $id_usuario);
					 if($ConsultorRV) $this->ion_auth->add_to_group(6, $id_usuario);
					 if($ConsultorRVInt) $this->ion_auth->add_to_group(12, $id_usuario);
					 if($Supervisores) $this->ion_auth->add_to_group(7, $id_usuario);
					 if($JefeArea) $this->ion_auth->add_to_group(8, $id_usuario);
					 if($ResponsableArmado) $this->ion_auth->add_to_group(9, $id_usuario);
					 if($GerenteProduccion) $this->ion_auth->add_to_group(10, $id_usuario);
					 $user = $this->ion_auth->user()->row();
					 $usuario_act= $user->id;
					
					 $registro=$this->Ion_auth_model->registrar_subordinado($usuario_act, $id_usuario);
					 
					 $this->load->library('upload', $config);
					 //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR 
						if (!$this->upload->do_upload()) {
							$datos['error'] =  $this->upload->display_errors();
							$this->notificacion = "No se pudo cargar la foto";
		                    $this->notificacion_error = true;
						} else {
						//EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
						//ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
							$file_info = $this->upload->data();
							//USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
							//ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
							$this->_create_thumbnail($file_info['file_name']);
							$data = array('upload_data' => $this->upload->data());
							$titulo = $this->input->post('nombre');
							$imagen = $file_info['file_name'];
							$subir = $this->upload_model->subir($id_usuario,$titulo,$imagen);						
						}
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el usuario.";
		             $this->notificacion_error = true;
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 
		 }
		 if($this->notificacion_error == true){	   
		              		   
			$datos['notificacion'] = $this->notificacion ? $this->notificacion : "Error registrando el usuario " . $usuario;
          	$datos['notificacion_error'] = $this->notificacion_error;
			$datos['modo_edicion'] = false;
						
			$datos['nombre']  	= $nombre;
         	$datos['apellidos'] = $apellidos;
         	$datos['empresa']  	= $empresa;
         	$datos['telefono']  = $telefono;
		 	$datos['email']  	= $email;
         	$datos['clave']  	= $clave;
         	$datos['rclave']  	= $rclave;
		   		
			$this->load->view('lte_header', $datos);
			$this->load->view('v_usuarios', $datos);
			$this->load->view('lte_footer', $datos); 
		 }else
		 $this->index();
		 
		 
	}
	public function registrar_usuario_revendedor()
    {
		 $pin 		= $this->input->post('pin');
		 $nombre 		= $this->input->post('nombre');
         $apellidos 	= $this->input->post('apellidos');
         $empresa 		= 'DVIGI';
         $telefono 		= $this->input->post('telefono');
		 $email 		= $this->input->post('email');
         $clave 		= $this->input->post('clave');
         $rclave 		= $this->input->post('rclave');
         $sel_municipios = $this->input->post('sel_municipios');
         $dni 			= $this->input->post('dni');
         $celular 		= $this->input->post('celular');
         $calle 		= $this->input->post('calle');
         $entrecalle1 	= $this->input->post('entrecalle1');
         $entrecalle2 	= $this->input->post('entrecalle2');
         $nro 			= $this->input->post('nro');
         $piso 			= $this->input->post('piso');
         $dpto 			= $this->input->post('dpto');
         $cuit 			= $this->input->post('cuit');
		 $codigo_postal = $this->input->post('codigo_postal');
		 $fecha_nacimiento='';

		 $Administradores 	= 0;
		 $Miembros 			= 2;
		 $Despachadores 	= 0;
		 $Revendedores		= 0;
		 $Consultores 		= 0;
		 $ConsultorRV		= 6;
		 $Supervisores 		= 0;
		 $JefeArea 			= 0;
		 $ResponsableArmado = 0;
		 $GerenteProduccion = 0;


		 $this->load->library('form_validation');
		 
		 $this->form_validation->set_rules('nombre', 'Nombre', 'required');
		 $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
		 $this->form_validation->set_rules('empresa', 'Compañia', 'trim');
		 $this->form_validation->set_rules('email', 'email', 'required|valid_email');
		 $this->form_validation->set_rules('telefono', 'Teléfono', 'numeric');
		 $this->form_validation->set_rules('clave', 'Contraseña', 'required|min_length[7]|max_length[15]|matches[rclave]');
		 $this->form_validation->set_rules('rclave', 'Confirmación de contraseña', 'required');
		 $this->form_validation->set_rules('sel_municipios', 'Localidad', 'required');
		 $this->form_validation->set_rules('celular', 'Celular', 'numeric');
		 $this->form_validation->set_rules('codigo_postal', 'Código Postal', 'required');
		 $this->form_validation->set_rules('nro', 'Número', 'required');


		 if ($this->form_validation->run() == true )
		 {		 
			
			$config['upload_path'] = 'uploads/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2000';
			$config['max_width'] = '2024';
			$config['max_height'] = '2008';
			
			$email    = strtolower($email);
            $identity = $email;
            $password = $clave;
			$activation_code = mt_rand(10000000,99999999);
			$first_name =  $nombre;
            $last_name  = $apellidos;
            $company    = $empresa;
			$phone      = $telefono;	
           

			 //$registrado = $this->ion_auth->register($identity, $password, $email, $additional_data);
			 $id_usuario=$this->Ion_auth_model->obt_id_user($email);
			 $mensaje = "";
			 if ($this->ion_auth->register_rev( $id_usuario,$identity, $password, $email, $activation_code,$first_name, $last_name, $company, $phone))
				 { 
					 
					 $result = $this->M_operaciones->reg_datos_revendedor($id_usuario, $sel_municipios, $dni, $nombre, $apellidos,  $telefono, $email, $codigo_postal, $calle, $nro, $piso, $dpto, $entrecalle1, $entrecalle2, $fecha_nacimiento, $celular, $cuit);

					 $this->notificacion = "Se ha registrado un nuevo usuario.";
		             $this->notificacion_error = false;

					 
					 if($Administradores) $this->ion_auth->add_to_group(1, $id_usuario);
					 if($Despachadores) $this->ion_auth->add_to_group(3, $id_usuario);
					 if($Revendedores) $this->ion_auth->add_to_group(4, $id_usuario);
					 if($Consultores) $this->ion_auth->add_to_group(5, $id_usuario);
					 if($ConsultorRV) $this->ion_auth->add_to_group(6, $id_usuario);
					 if($Supervisores) $this->ion_auth->add_to_group(7, $id_usuario);
					 if($JefeArea) $this->ion_auth->add_to_group(8, $id_usuario);
					 if($ResponsableArmado) $this->ion_auth->add_to_group(9, $id_usuario);
					 if($GerenteProduccion) $this->ion_auth->add_to_group(10, $id_usuario);
					 $jrev = $this->M_configuracion->obt_usuarios_jr();
					 foreach ($jrev->result() as $key) {
						 # code...
						 $registro=$this->Ion_auth_model->registrar_subordinado($key->user_id, $id_usuario);
					 }					
					 
					 
					 $this->load->library('upload', $config);
					 //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR 
						if (!$this->upload->do_upload()) {
							$datos['error'] =  $this->upload->display_errors();
							$this->notificacion = "No se pudo cargar la foto";
		                    $this->notificacion_error = true;
						} else {
						//EN OTRO CASO SUBIMOS LA IMAGEN, CREAMOS LA MINIATURA Y HACEMOS 
						//ENVÍAMOS LOS DATOS AL MODELO PARA HACER LA INSERCIÓN
							$file_info = $this->upload->data();
							//USAMOS LA FUNCIÓN create_thumbnail Y LE PASAMOS EL NOMBRE DE LA IMAGEN,
							//ASÍ YA TENEMOS LA IMAGEN REDIMENSIONADA
							$this->_create_thumbnail($file_info['file_name']);
							$data = array('upload_data' => $this->upload->data());
							$titulo = $this->input->post('nombre');
							$imagen = $file_info['file_name'];
							$subir = $this->upload_model->subir($id_usuario,$titulo,$imagen);						
						}
						$email1 = str_replace("@","Alt64Al",$email);
						
						redirect('activar_revendedor/'.$email1.'/'.$activation_code, 'refresh');
				 }
				 else
				 {
					 $this->notificacion = "ERROR. No se pudo registrar el usuario.";
					 $this->notificacion_error = true;
					 $datos['notificacion'] = $this->notificacion;
					 $datos['notificacion_error'] = $this->notificacion_error;
					 $datos['email']  		= $email;
					 $datos['pin'] 		= $pin;
					$datos['provincias'] 		= $this->M_operaciones->provincias();
					$this->load->view('registro', $datos);
				 }
				 
		 }
		 else
		 {
		     $this->notificacion = validation_errors();
			 $this->notificacion_error = true;
			 $datos['notificacion'] = $this->notificacion;
			 $datos['notificacion_error'] = $this->notificacion_error;
			 $datos['email']  		= $email;
			 $datos['pin'] 		= $pin;
			$datos['provincias'] 		= $this->M_operaciones->provincias();
        	$this->load->view('registro', $datos);
		 }
		 
		 	
		 
		 
    }
	function _create_thumbnail($filename){
        $config['image_library'] = 'gd2';
        //CARPETA EN LA QUE ESTÁ LA IMAGEN A REDIMENSIONAR
        $config['source_image'] = 'uploads/'.$filename;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        //CARPETA EN LA QUE GUARDAMOS LA MINIATURA
        $config['new_image']='uploads/thumbs/';
        $config['width'] = 150;
        $config['height'] = 150;
        $this->load->library('image_lib', $config); 
        $this->image_lib->resize();
    }
}
