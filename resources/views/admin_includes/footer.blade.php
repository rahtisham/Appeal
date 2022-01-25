 <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/" target="_blank">DexignZone</a> 2021</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('admin_assets/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/deznav-init.js') }}"></script>
    
    <!-- Counter Up -->
    <script src="{{ asset('admin_assets/vendor/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('admin_assets/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>   
        
    <!-- Apex Chart -->
    <script src="{{ asset('admin_assets/vendor/apexchart/apexchart.js') }}"></script> 
    
    <!-- Chart piety plugin files -->
    <script src="{{ asset('admin_assets/vendor/peity/jquery.peity.min.js') }}"></script>
    
    <!-- Dashboard 1 -->
    <script src="{{ asset('admin_assets/js/dashboard/dashboard-1.js') }}"></script>
    
    <!-- Datatable -->
    <script src="{{ asset('js/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script>
    (function($) {
     
        var table = $('#example5').DataTable({
            searching: false,
            paging:true,
            select: false,
            //info: false,         
            lengthChange:false 
            
        });
        $('#example tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            
        });
       
    })(jQuery);
    </script>

    <script type="text/javascript">
      $(document).ready(function() {
    // show the alert
     setTimeout(function() {
        $(".alert-success").alert('close');
        $(".alert-warning").alert('close');
    }, 3000);
});
    </script>
    
    
</body>
</html>