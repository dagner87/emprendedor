 </div>
 <!-- /.container-fluid -->

            <footer class="footer text-center"> 2017 &copy; SOFTCOM SAS </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
   
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

    <!-- Calendar JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/moment/moment.js"></script>
    <script src='<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/fullcalendar.min.js'></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/jquery.fullcalendar.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/cal-init.js"></script>
    
    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jquery.slimscroll.js"></script>
   
    <!--Counter js -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!-- chartist chart -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
      <!-- Sweet-Alert  -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/custom.min.js"></script>
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/dashboard1.js"></script>

    <script src="<?php echo base_url();?>assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    
    <script src="<?php echo base_url();?>assets/plugins/bower_components/switchery/dist/switchery.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>

     <!-- Magnific popup JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        
    <!--Wave Effects -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/animated-masonry-gallery.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/fancybox/ekko-lightbox.min.js"></script>
    <script type="text/javascript">



    $(document).ready(function($) {

      $("input[name='tch3_22']").TouchSpin({
                initval: 500
            });
        // delegate calls to data-toggle="lightbox"
        $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
            event.preventDefault();
            return $(this).ekkoLightbox({
                onShown: function() {
                    if (window.console) {
                        return console.log('Checking our the events huh?');
                    }
                },
                onNavigate: function(direction, itemIndex) {
                    if (window.console) {
                        return console.log('Navigating ' + direction + '. Current item: ' + itemIndex);
                    }
                }
            });
        });
        //Programatically call
        $('#open-image').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        // navigateTo
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
            event.preventDefault();
            var lb;
            return $(this).ekkoLightbox({
                onShown: function() {
                    lb = this;
                    $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                        e.preventDefault();
                        lb.navigateTo(2);
                    });
                }
            });
        });
    });
    </script>

    <script>

    $(document).ready(function(){
      load_data();
       // console.log("cargo");
        $('#add_asoc').submit(function(e) {
        e.preventDefault();
         enviardatos();
        
      });

      //enviar solicitud a asociado
        
       $('#add_emp').submit(function(e) {
        e.preventDefault();
        var url = '<?php echo base_url() ?>panel_admin/insert_emp';
        var data = $('#add_emp').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");

                      }
                 })
                  .done(function(){
                    console.log(data);
                    
                     swal("Buen Trabajo!!", "Nuevo Emprendedor Agregado.", "success");
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/
                     load_data();

                  });
        
      }); 


    });

    function load_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataemp",
            method:"POST",
            success:function(data)
            {
               $('#contenido').html(data);
               
                var table_import = $('#tabla-emp').DataTable({
                                     responsive: true,
                                     language: {
                                                  "lengthMenu": "Mostrar _MENU_ registros por pagina",
                                                  "zeroRecords": "No se encontraron resultados en su busqueda",
                                                  "searchPlaceholder": "Buscar registros",
                                                  "info": "Mostrando  _START_ al _END_ de un total de  _TOTAL_ registros",
                                                  "infoEmpty": "No existen registros",
                                                  "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                                                  "search": "Buscar:",
                                                  "paginate": {
                                                                "first": "Primero",
                                                                "last": "Último",
                                                                "next": "Siguiente",
                                                                "previous": "Anterior"
                                                              },
                                        }

                                    });

               table_import.$('.tooltip-prod').tooltip({
                selector: "[data-toggle=tooltip]",
                container: "body"
               });
               
               table_import.$('input[type="text"]').on('change', this, function(){
                 var val = $(this).val();
                 var name = $(this).attr("name");
                 var valor =  $(this).attr("id").split('_');
                 console.log(valor[0]+"-"+val+"-"+valor[1]);
            
             $.get( "<?php echo base_url();?>csv_import/updateTable",{ 
                   id_producto:valor[1],
                   campo:valor[0],
                   valor:val
                  })
                .done(function(data) {
                  console.log(data);
                 $('#capa_'+valor[0]+valor[1]).html('<i class="fa fa-spinner fa-spin"></i>').fadeIn().delay(2000).fadeOut('slow');
                              
                }); 

                }); 
            }
        })
    }

     function enviardatos(){
          var url = '<?php echo base_url() ?>capacitacion/insert_add_asoc';
          var data = $('#add_asoc').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");
                      }
                 })
                  .done(function(){
                    console.log(data);
                    
                     swal("Buen Trabajo!!", "Nuevo Asociado Agregado.", "success");
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/

                  });
        } 
    
    

    </script>


</body>
</html>
