 </div>
 <!-- /.container-fluid -->

            <footer class="footer text-center"> 2017 &copy; SOFTCOM SAS </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
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
    <!--Wave Effects -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>
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
     <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

     <!-- Magnific popup JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/animated-masonry-gallery.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/fancybox/ekko-lightbox.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function($) {
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
       // console.log("cargo");
        $('#add_asoc').submit(function(e) {
        e.preventDefault();
         enviardatos();
        
      });   
    });

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
