 <script src="<?php echo SITE_URL?>dist/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo SITE_URL?>dist/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="<?php echo SITE_URL?>dist/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo SITE_URL?>dist/assets/js/off-canvas.js"></script>
    <script src="<?php echo SITE_URL?>dist/assets/js/misc.js"></script>
    <script src="<?php echo SITE_URL?>dist/assets/js/settings.js"></script>
    <script src="<?php echo SITE_URL?>dist/assets/js/todolist.js"></script>
    <script src="<?php echo SITE_URL?>dist/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="<?php echo SITE_URL?>dist/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
     <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <!-- DataTables -->
   <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

   <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
      <script>
      $(document).ready(function () {
         $('#myDataTable').DataTable({
            pageLength: 10,
            lengthMenu: [
                  [10, 25, 50, 100],
                  [10, 25, 50, 100]
            ],
            ordering: true,
            searching: true,
            paging: true,
            info: true,
            responsive: true
         });
      });
      </script>

      <script>

$(document).ready(function(){

    $('#selectcountry').change(function(){

        var country_id = $(this).val();

        $.ajax({

            url:'ajax/get_state.php',

            type:'POST',

            data:{country_id:country_id},

            success:function(data){
                

                $('#selectstate').html(data);

                $('#selectcity').html('<option value="">Select City</option>');

            }

        });

    });




    $('#selectstate').change(function(){

        var state_id=$(this).val();

        $.ajax({

            url:'ajax/get_city.php',

            type:'POST',

            data:{state_id:state_id},

            success:function(data){

                $('#selectcity').html(data);

            }

        });

    });

});

</script>