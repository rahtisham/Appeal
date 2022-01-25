<!--**********************************
            Footer start
        ***********************************-->
        <div class="footer p-0">
            <div class="copyright">
                <strong>Copyright © 2020.</strong>  All rights reserved.
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
   
    <script src="{{ asset('js/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/deznav-init.js') }}"></script>
    <script src="{{ asset('js/global/global.min.js') }}"></script> 
    <script src="{{ asset('js/custom.min.js') }}"></script>

    <!-- Counter Up -->
    <script src="{{ asset('js/waypoints/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup/jquery.counterup.min.js') }}"></script>
    
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
    
</body>
</html>