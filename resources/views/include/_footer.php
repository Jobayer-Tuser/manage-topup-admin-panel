    </div>
</div>
<!--  BEGIN FOOTER  -->
<div class="footer-wrapper">
    <div class="footer-section f-section-1">
        <p class="">Copyright © <span class="dynamic-year">2022</span> <a target="_blank" href="https://designreset.com/cork-admin/">DesignReset</a>, All rights reserved.</p>
    </div>
    <div class="footer-section f-section-2">
        <p class="">Coded with <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></p>
    </div>
</div>
<!--  END FOOTER  -->
</div>
<!--  END CONTENT AREA  -->

</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="public/assets/src/plugins/src/global/vendors.min.js"></script>
<script src="public/assets/src/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="public/assets/src/plugins/src/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="public/assets/src/plugins/src/mousetrap/mousetrap.min.js"></script>
<script src="public/assets/src/plugins/src/waves/waves.min.js"></script>
<script src="public/assets/src/assets/js/custom.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

<script src="public/assets/src/plugins/src/apex/apexcharts.min.js"></script>
<script src="public/assets/src/plugins/src/table/datatable/datatables.js"></script>
<script src="public/assets/src/plugins/src/table/datatable/custom_miscellaneous.js"></script>
<script>
    $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 10
    });
</script>

<script src="public/assets/src/plugins/src/flatpickr/flatpickr.js"></script>
<script type="text/javascript">
    var f2 = flatpickr(document.getElementsByClassName('flatpickr'), {
        enableTime: true,
        dateFormat: "Y-m-d h:i:s",

    });
</script>

    <script src="public/assets/src/plugins/src/notification/snackbar/snackbar.min.js"></script>
    <script src="public/assets/src/assets/js/components/notification/custom-snackbar.js"></script>
    <script>
        // add_notification('.snackbar-bg-success', {
        //     text: 'Success',
        //     actionTextColor: '#fff',
        //     backgroundColor: '#00ab55'
        // })
    </script>

</body>
</html>