 <form id="test-form" class="mfp-hide white-popup-block">
        <!-- progressbar -->
        <ul id="eliteregister">
        <li class="active">Account Setup</li>
        <li>Social Profiles</li>
        <li>Personal Details</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>
        <h2 class="fs-title">Create your account</h2>
        <h3 class="fs-subtitle">This is step 1</h3>
        <input type="text" name="email" placeholder="Email" />
        <input type="password" name="pass" placeholder="Password" />
        <input type="password" name="cpass" placeholder="Confirm Password" />
        <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
        <h2 class="fs-title">Social Profiles</h2>
        <h3 class="fs-subtitle">Your presence on the social network</h3>
        <input type="text" name="twitter" placeholder="Twitter" />
        <input type="text" name="facebook" placeholder="Facebook" />
        <input type="text" name="gplus" placeholder="Google Plus" />
        <input type="button" name="previous" class="previous action-button" value="Previous" />
        <input type="button" name="next" class="next action-button" value="Next" />
        </fieldset>
        <fieldset>
        <h2 class="fs-title">Personal Details</h2>
        <h3 class="fs-subtitle">We will never sell it</h3>
        <input type="text" name="fname" placeholder="First Name" />
        <input type="text" name="lname" placeholder="Last Name" />
        <input type="text" name="phone" placeholder="Phone" />
        <textarea name="address" placeholder="Address"></textarea>
        <input type="button" name="previous" class="previous action-button" value="Previous" />
        <input type="submit" name="submit" class="submit action-button" value="Submit" />
        </fieldset>
 </form>


  <div class="col-sm-6">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Form Validation</h3>
                            <p class="text-muted m-b-30"> Bootstrap Form Validation11</p>
                            <form data-toggle="validator">
                                <div class="form-group">
                                    <label for="inputName" class="control-label">Name</label>
                                    <input type="text" class="form-control" id="inputName" placeholder="Cina Saffary" required> </div>
                                <div class="form-group">
                                    <label for="inputEmail2" class="control-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail2" placeholder="Email" data-error="Bruh, that email address is invalid" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword2" class="control-label">Password</label>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <input type="password" data-toggle="validator" data-minlength="6" class="form-control" id="inputPassword2" placeholder="Password" required> <span class="help-block">Minimum of 6 characters</span> </div>
                                        <div class="form-group col-sm-6">
                                            <input type="password" class="form-control" id="inputPasswordConfirm2" data-match="#inputPassword" data-match-error="Whoops, these don't match" placeholder="Confirm" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox">
                                        <input type="checkbox" id="terms2" data-error="Before you wreck yourself" required>
                                        <label for="terms"> Remember Me?</label>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div> 


   <script>

$(document).ready(function(){
           jQuery.validator.setDefaults({
      debug: true,
      success: "valid"
    });

    jQuery.extend(jQuery.validator.messages, {
      required: "<strong style='color: red'>*Este campo es obligatorio.</strong>",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "<strong style='color: red'>*Por favor, escribe un número entero válido.</strong>",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: jQuery.validator.format("<strong style='color: red'>*Por favor, no escribas más de {0} caracteres.</strong>"),
      minlength: jQuery.validator.format("<strong style='color: red'>*Por favor, no escribas menos de {0} caracteres.</strong>"),
      rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });
    
   $( "#test-form" ).validate({
    rules: {
      email:{
        required: true,
        number: true,
        minlength: 1
      },
      horas_fact_cap_aux:{
         number: true,
        minlength: 1
      }
    }
  });

});                              
