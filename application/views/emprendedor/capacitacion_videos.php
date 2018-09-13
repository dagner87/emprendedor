<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">CAPACITACION</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li><a href="<?php echo base_url();?>">Capacitación</a></li>
                            <li class="active">Videos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- .row -->

<div class="row">
    <div class="col-md-12">
        <div class="alert alert-warning"> DEBE COMPLETAR LOS VIDEOS DE CAPACITACION PARA TENER ACCESO A LAS DEMAS PESTAÑAS DEL MENU. </div>
        <div class="panel-group" role="tablist" aria-multiselectable="true">
            <!--pestañas de videos-->    
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="font-bold">  Video #1 </a> </h4> </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body"> 
                        <div class="col-md-12">
                            <div class="white-box">
                                <h3 class="box-title">INTRODUCCION</h3>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <a class="popup-youtube btn btn-default" title="Ver Video" href="https://www.youtube.com/watch?v=zMVw3QamjA0"><img src="<?php echo base_url();?>assets/videos/purificador-gris.jpg" class="img-responsive" /></a></div>
                                    <div class="col-sm-9" id="slimtest1">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam rhoncus, felis interdum condimentum consectetur, nisl libero elementum eros, vehicula congue lacus eros non diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                                        <p>Vivamus mauris lorem, lacinia id tempus non, imperdiet et leo. Cras sit amet erat sit amet lacus egestas placerat. </p>
                                        <p><a class="popup-with-form btn btn-success" href="#test-form">Evaluación #1</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <!--pestañas de videos-->      
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title"> <a class="collapsed font-bold" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" > How to modify Navigation ? </a> </h4> </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, </div>
                </div>
            </div>
        </div>
    </div>
</div>  
 <!-- .row -->

<!-- form itself -->
            <form id="test-form" class="mfp-hide white-popup-block">
                <h1>Form</h1>
                <fieldset style="border:0;">
                    <p>Lightbox has an option to automatically focus on the first input. It's strongly recommended to use <code>inline</code> popup type for lightboxes with form instead of <code>ajax</code> (to keep entered data if the user accidentally refreshed the page).</p>
                    <div class="form-group">
                        <label class="control-label" for="inputName">Name</label>
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="inputEmail">Email</label>
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="example@domain.com" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="inputPhone">Phone</label>
                        <input type="tel" class="form-control" id="inputPhone" name="phone" placeholder="Eg. +447500000000" required=""> </div>
                    <div class="form-group">
                        <label class="control-label" for="textarea">Textarea</label>
                        <br>
                        <textarea class="form-control" id="textarea">Try to resize me to see how popup CSS-based resizing works.</textarea>
                    </div>
                </fieldset>
            </form>              


