<!-- footer -->

<!-- if you like you can insert your footer here -->

<!-- end footer -->

<!--================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- Placed at the end of the document so the pages load faster -->

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="/theme/js/libs/jquery.min.js"><\/script>')</script>
<!-- OPTIONAL: Use this migrate script for plugins that are not supported by jquery 1.9+ -->
        <!-- DISABLED <script src="/theme/js/libs/jquery.migrate-1.0.0.min.js"></script> -->
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script>window.jQuery.ui || document.write('<script src="/theme/js/libs/jquery.ui.min.js"><\/script>')</script>

<!-- IMPORTANT: Jquery Touch Punch is always placed under Jquery UI -->
<script src="/theme/js/include/jquery.ui.touch-punch.min.js"></script>

<!-- REQUIRED: Mobile responsive menu generator -->
<script src="/theme/js/include/selectnav.min.js"></script>

<!-- REQUIRED: Datatable components -->
<script src="/theme/js/include/jquery.accordion.min.js"></script>

<!-- REQUIRED: Toastr & Jgrowl notifications  -->
<script src="/theme/js/include/toastr.min.js"></script>
<script src="/theme/js/include/jquery.jgrowl.min.js"></script>

<!-- REQUIRED: Sleek scroll UI  -->
<script src="/theme/js/include/slimScroll.min.js"></script>

<!-- REQUIRED: Datatable components -->
<script src="/theme/js/include/jquery.dataTables.min.js"></script>
<script src="/theme/js/include/DT_bootstrap.min.js"></script>

<!-- REQUIRED: Form element skin  -->
<script src="/theme/js/include/jquery.uniform.min.js"></script>

<!-- REQUIRED: AmCharts  -->
<script src="/theme/js/include/amchart/amcharts.js"></script>
<script src="/theme/js/include/amchart/amchart-draw1.js"></script>

<script type="text/javascript">
var ismobile = (/iphone|ipad|ipod|android|blackberry|mini|windows\sce|palm/i.test(navigator.userAgent.toLowerCase()));
if (!ismobile) {

    /** ONLY EXECUTE THESE CODES IF MOBILE DETECTION IS FALSE **/

    /* REQUIRED: Datatable PDF/Excel output componant */

    document.write('<script src="/theme/js/include/ZeroClipboard.min.js"><\/script>');
    document.write('<script src="/theme/js/include/TableTools.min.js"><\/script>');
    document.write('<script src="/theme/js/include/select2.min.js"><\/script>');
    document.write('<script src="/theme/js/include/jquery.excanvas.min.js"><\/script>');
    document.write('<script src="/theme/js/include/jquery.placeholder.min.js"><\/script>');

    /** DEMO SCRIPTS **/
    $(function() {
        /* show tooltips */
        $.jGrowl("I am the <strong>smartest Admin Template</strong> on <strong>wrapbootstrap.com</strong>. Don't forget to check out all my pages.", {
            header: 'Welcome, I am Jarvis!',
            sticky: false,
            life: 5000,
            speed: 500,
            theme: 'with-icon',
            position: 'top-right', //this is default position
            easing: 'easeOutBack',
            animateOpen: {
                height: "show"
            },
            animateClose: {
                opacity: 'hide'
            }
        });
    });
    /** end DEMO SCRIPTS **/

} else {

    /** ONLY EXECUTE THESE CODES IF MOBILE DETECTION IS TRUE **/

    document.write('<script src="/theme/js/include/selectnav.min.js"><\/script>');
}
</script>

<!-- REQUIRED: iButton -->
<script src="/theme/js/include/jquery.ibutton.min.js"></script>

<!-- REQUIRED: Justgage animated charts -->
<script src="/theme/js/include/raphael.2.1.0.min.js"></script>
<script src="/theme/js/include/justgage.min.js"></script>

<!-- REQUIRED: Morris Charts -->
<script src="/theme/js/include/morris.min.js"></script> 
<script src="/theme/js/include/morris-chart-settings.js"></script> 

<!-- REQUIRED: Animated pie chart -->
<script src="/theme/js/include/jquery.easy-pie-chart.min.js"></script>

<!-- REQUIRED: Functional Widgets -->
<script src="/theme/js/include/jarvis.widget.min.js"></script>
<script src="/theme/js/include/mobiledevices.min.js"></script>
<!-- DISABLED (only needed for IE7 <script src="/theme/js/include/json2.js"></script> -->

<!-- REQUIRED: Full Calendar -->
<script src="/theme/js/include/jquery.fullcalendar.min.js"></script>		

<!-- REQUIRED: Flot Chart Engine -->
<script src="/theme/js/include/jquery.flot.cust.min.js"></script>			
<script src="/theme/js/include/jquery.flot.resize.min.js"></script>		
<script src="/theme/js/include/jquery.flot.tooltip.min.js"></script>		
<script src="/theme/js/include/jquery.flot.orderBar.min.js"></script> 	
<script src="/theme/js/include/jquery.flot.fillbetween.min.js"></script>	
<script src="/theme/js/include/jquery.flot.pie.min.js"></script> 	 

<!-- REQUIRED: Sparkline Charts -->
<script src="/theme/js/include/jquery.sparkline.min.js"></script>

<!-- REQUIRED: Infinite Sliding Menu (used with inbox page) -->
<script src="/theme/js/include/jquery.inbox.slashc.sliding-menu.js"></script> 

<!-- REQUIRED: Form validation plugin -->
<script src="/theme/js/include/jquery.validate.min.js"></script>

<!-- REQUIRED: Progress bar animation -->
<script src="/theme/js/include/bootstrap-progressbar.min.js"></script>

<!-- REQUIRED: wysihtml5 editor -->
<script src="/theme/js/include/wysihtml5-0.3.0.min.js"></script>
<script src="/theme/js/include/bootstrap-wysihtml5.min.js"></script>

<!-- REQUIRED: Masked Input -->
<script src="/theme/js/include/jquery.maskedinput.min.js"></script>

<!-- REQUIRED: Bootstrap Date Picker -->
<script src="/theme/js/include/bootstrap-datepicker.min.js"></script>

<!-- REQUIRED: Bootstrap Wizard -->
<script src="/theme/js/include/bootstrap.wizard.min.js"></script> 

<!-- REQUIRED: Bootstrap Color Picker -->
<script src="/theme/js/include/bootstrap-colorpicker.min.js"></script>

<!-- REQUIRED: Bootstrap Time Picker -->
<script src="/theme/js/include/bootstrap-timepicker.min.js"></script> 

<!-- REQUIRED: Bootstrap Prompt -->
<script src="/theme/js/include/bootbox.min.js"></script>

<!-- REQUIRED: Bootstrap engine -->
<script src="/theme/js/include/bootstrap.min.js"></script>

<!-- DO NOT REMOVE: Theme Config file -->
<script src="/theme/js/config.js"></script>

<!-- d3 library placed at the bottom for better performance -->
<!-- DISABLED  <script src="/theme/js/include/d3.v3.min.js"></script> -->
<!-- DISABLED  <script src="/theme/js/include/adv_charts/d3-chart-1.js"></script> -->
<!-- DISABLED  <script src="/theme/js/include/adv_charts/d3-chart-2.js"></script> -->

<!-- Google Geo Chart -->
<!-- DISABLED <script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script> -->
<!-- DISABLED <script type='text/javascript' src='https://www.google.com/jsapi'></script>-->
<!-- DISABLED <script src="/theme/js/include/adv_charts/geochart.js"></script> -->

<!-- end scripts -->
