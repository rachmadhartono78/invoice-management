<!-- BEGIN: Vendor JS-->
<script src="{{ asset(mix('assets/vendor/libs/jquery/jquery.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/popper/popper.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/bootstrap.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/node-waves/node-waves.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/hammer/hammer.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/select2/select2.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/typeahead-js/typeahead.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/jquery-repeater/jquery-repeater.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/dropzone/dropzone.js')) }}"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>


<script>
    let accountMenu = {!!json_encode(session('data')) !!}
    //BM
    if(accountMenu?.level.id == 1){
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
        hideDashboard();
    }
    //KA
    if(accountMenu?.level.id == 2){
        hideSubMenu("List Work Order");
        hideDashboard();
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    
   
    //Koordinator
    if(accountMenu?.level.id == 3){
        hideMenu("Invoice");
        hideDashboard();
        hideMenu("Request");
        hideSubMenu("List Work Order");
        hideSubMenu("List Ticket");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    //Leader Cleaning
    if(accountMenu?.level.id == 4){
        hideMenu("Invoice");
        hideDashboard();
        hideMenu("Request");
        hideSubMenu("List Work Order");
        hideSubMenu("List Ticket");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    //Teknisi
    if(accountMenu?.level.id == 5){
        hideDashboard();
        hideMenu("Invoice");
        hideMenu("Request");
        hideSubMenu("List Laporan Kerusakan");
        hideSubMenu("List Ticket");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    
    //Chief Engineering
    if(accountMenu?.level.id == 6){
        hideMenu("Invoice");
        hideDashboard();
        hideMenu("Request");
        hideSubMenu("List Laporan Kerusakan");
        hideSubMenu("List Ticket");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    //WareHouse
    if(accountMenu?.level.id == 7){
        hideMenu("Invoice");
        hideDashboard();
        hideSubMenu("List Laporan Kerusakan");
        hideSubMenu("List Ticket");
        hideSubMenu("List Purchase Request");
        hideSubMenu("List Purchase Order");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }
    if(accountMenu?.level.id == 8){
        hideMenu("Invoice");
        hideMenu("Complain");
        hideSubMenu("List Purchase Request");
        hideSubMenu("List Purchase Order");
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
        hideDashboard();
    }
   
    if(accountMenu?.level.id == 9){
        hideSubMenu("List Work Order");
        hideDashboard();
        hideMenu("Client");
        hideMenu("Vendor");
        hideMenu("Report");
        hideMenu("Settings");
    }

    function hideDashboard(){
        var aTags = document.getElementsByClassName("icon-home");
        aTags[0].parentElement.parentElement.classList.add('d-none');
    }
    if(accountMenu?.level.id == 11){
        hideMenu("Invoice");
        hideMenu("Request");
        hideMenu("Complain");
        hideSubMenu("List Purchase Request");
        hideSubMenu("List Tanda Terima");
        hideSubMenu("List Purchase Order");
        hideMenu("Client");
        hideMenu("Report");
        hideMenu("Settings");
    }

    function hideSubMenu(menu) {
        var aTags = document.getElementsByTagName("div");
        var searchText = menu;
        var found;

        for (var i = 0; i < aTags.length; i++) {
            if (aTags[i].textContent == searchText) {
                found = aTags[i];
                found.parentElement.parentElement.classList.add('d-none');
                break;

            }
        }
    }
   
    function hideMenu(menu) {
        var aTags = document.getElementsByTagName("div");
        var searchText = menu;
        var found;

        for (var i = 0; i < aTags.length; i++) {
            if (aTags[i].textContent == searchText) {
                found = aTags[i];
                found.parentElement.classList.add('d-none');
                break;

            }
        }
    }


    
</script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>
<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

@stack('modals')
@livewireScripts