@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'To do List')

@section('content')

<div class="row" id="tables">

</div>



@endsection
@section('page-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script>
    "use strict";
    let account = {!! json_encode(session('data')) !!};
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    $((function() {
       
        let columnsInvoice = [{
            name: "invoice_number",
            data: "invoice_number",
            title: "No. Invoice",
            render: function(data, type, row) {
                return data;
            }
        }, 
        {
            name: "tenant",
            data: "tenant",
            title: "Tenant",
            render: function(data, type, row) {
                return data?.company ? data?.company : '';
            }
        }, {
            data: "id",
            name: "tanggapan",
            title: "Action",
            render: function(data, type, row) {
                let sendMailRow = '';
                let editButton = '';
                let deleteButton = '';
                if (row.status == 'Disetujui BM' && account.level.id == 10) {
                    sendMailRow = `<a href="#" data-bs-toggle="tooltip" class="text-body send-email" data-id="${data}" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>`;
                }
                if ((account.level.id == 10 && row.status == 'Terbuat') || (account.level.id == 1 && row.status == 'Disetujui KA')) {
                    editButton = `<a href="{{ url("invoice/edit")}}/${data}" class="dropdown-item">Edit</a>`;
                }
                if ((account.level.id == 10)) {
                    deleteButton = `<div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>`;
                }
                let previewRow = '<a href="{{ url("invoice/show")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                return `<div class="d-flex align-items-center">
                        ` + sendMailRow + previewRow + `
                        <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{url('invoice/print')}}/` + data + `" class="dropdown-item">Download</a>${editButton}${deleteButton}</div></div></div>`
            }

        }];

        let columnTandaTerima = [{
            data: "receipt_number",
            name: "receipt_number",
            title: "No Tanda Terima",
            render: function(data, type, row) {
                return data;
            }
        }, {
            data: "tenant",
            name: "tenant",
            title: "Tenant",
            render: function(data, type, row) {
                return data?.company ? data?.company : '';
            }
        }, {
            data: 'id',
            name: 'tanggapan',
            title: "Action",
            render: function(data, type, row) {
                let sendMailRow = '';
                let editButton = '';
                let deleteButton = '';
                if (row.status == 'Disetujui BM' && account.level.id == 10) {
                    sendMailRow = `<a href="#" data-bs-toggle="tooltip" class="text-body send-email-receipt" data-id="${data}" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>`;
                }
                if ((account.level.id == 10 && row.status == 'Terbuat') || (account.level.id == 1 && row.status == 'Disetujui KA')) {
                    editButton = `<a href="/invoice/tanda-terima/edit/${data}" class="dropdown-item btn-edit" data-id="${data}">Edit</a>`;
                }
                if ((account.level.id == 10)) {
                    deleteButton = `<a href="javascript:;" class="dropdown-item delete-record text-danger btn-delete" data-id="${data}">Delete</a>`;
                }
                return `<div class="d-flex align-items-center">
                                    ${sendMailRow}
                                    <a href="invoice/tanda-terima/show/${data}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Show Tanda Terima"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a target="_blank" href="{{url('invoice/tanda-terima/print')}}/` + data + `" class="dropdown-item">Download</a>
                                            ${editButton}
                                            ${deleteButton}
                                        </div>
                                    </div>
                                </div>`;
            }
        }];


        let columnTicket = [{
            name: "ticket_number",
            data: "ticket_number",
            title: "No. Ticket",
            className: 'text-center',
            render: function(data, type, row) {
                return data;
            }
        }, {
            name: "reporter_name",
            data: "reporter_name",
            title: "Nama Pelapor",
            className: 'text-center',
            render: function(data, type, row) {
                return data;
            }
        }, {
            data: "id",
            name: "tanggapan",
            title: "Action",
            render: function(data, type, row) {
                let editRow = '';
                let previewRow = '<a href="{{ url("complain/show-ticket")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                return `<div class="d-flex align-items-center">
                            ` + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="{{ url("complain/edit-ticket")}}/` + data + `" class="dropdown-item">Edit</a>
                            <div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>`
            }
        }]
 
        let columnLaporanKerusakan = [{
            data: "damage_report_number",
            name: "damage_report_number",
            title: "No LK",
            className: 'text-center'
        }, {
            data: "scope",
            name: "scope",
            title: "Scope",
            className: 'text-center'
        }, {
            data: 'id',
            name: 'tanggapan',
            title: "Action",
            render: function(data, type, row) {
                return '<div class="d-flex align-items-center"><a href="/complain/laporan-kerusakan/show/' +
                    data +
                    '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Laporan Kerusakan"><i class="ti ti-eye mx-2 ti-sm"></i></a><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="/complain/laporan-kerusakan/print/' +
                    data + '" class="dropdown-item">Download</a><a href="/complain/laporan-kerusakan/edit/' +
                    data + '" class="dropdown-item btn-edit" data-id="' +
                    data +
                    '">Edit</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger btn-delete" data-id="' +
                    data + '">Delete</a></div></div></div>'
            }
        }];

        let columnWorkOrder = [{
            data: "work_order_number",
            name: "work_order_number",
            title: "No. Work Order"
        }, {
            data: "scope",
            name: "scope",
            title: "Scope"
        }, {
            data: "id",
            name: "tanggapan",
            title: "Action",
            render: function(data, type, row) {
                return '<div class="d-flex align-items-center"><a href="/complain/work-order/show/' +
                    data +
                    '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="/complain/work-order/print/' +
                    data + '" class="dropdown-item">Download</a><a href="/complain/work-order/edit/' +
                    data + '" class="dropdown-item btn-edit" data-id="' +
                    data +
                    '">Edit</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>'
            }
        }];

        let columnMaterialRequest = [{
            name: "material_request_number",
            data: "material_request_number",
            title: "No. Material Request",
            className: 'text-center'
        }, {
            name: "requester",
            data: "requester",
            title: "Requester",
            className: 'text-center'
        }, {
            data: "id",
            name: "tanggapan",
            title: "Action",
            render: function(data, type, row) {
                let editRow = '';
                let sendMailRow = '<a href="javascript:;" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>';
                let previewRow = '<a href="{{ url("request/material-request/show")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Material Request"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                return `<div class="d-flex align-items-center">
                            ` + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{ url("request/material-request/print")}}/` + data + `"" class="dropdown-item">Download</a><a href="{{ url("request/material-request/edit")}}/` + data + `" class="dropdown-item">Edit</a>
                            <div class="dropdown-divider"></div><a href="#" data-id="${data}" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>`
            }
        }];

        let columnPurchaseRequest = [{
            data: "purchase_request_number",
            name: "purchase_request_number",
            title: "Purchase Request Number",
            className: 'text-center'
        }, {
            data: "department",
            name: "department",
            title: "Department",
            className: 'text-center',
            render: function(data, type, row) {
                return data.name ? data.name : '';
            }
        }, {
            data: "id",
            name: "id",
            title: "Action",
            render: function(data, type, row) {
                return '<div class="d-flex align-items-center"><a href="/request/show/' +
                    data +
                    '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="javascript:;" class="dropdown-item">Download</a><a href="/request/edit/' +
                    data + '" class="dropdown-item btn-edit" data-id="' +
                    data +
                    '">Edit</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger btn-delete" data-id="' +
                    data + '">Delete</a></div></div></div>'
            }
        }];


        var columnPurchaseOrder = [{
            name: "No. PO",
            data: "purchase_order_number",
            title: "No. PO",
            className: 'text-center',
            render: function(data, type, row) {
                return data;
            }
        }, {
            name: "vendor",
            data: "vendor",
            title: "Vendor",
            className: 'text-center',
            render: function(data, type, row) {
                return data.name ? data.name : '';
            }
        }, {
            data: "id",
            name: "Action",
            title: "Action",
            render: function(data, type, row) {
                let editRow = '';
                let sendMailRow = '';
                if (row.status == 'Disetujui BM' && account.level.id == 10) {
                    sendMailRow = `<a href="#" data-bs-toggle="tooltip" class="text-body send-email-po" data-id="${data}" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>`;
                }
                let previewRow = '';
                let btnDelete = '';
                let btnEdit = '';
                if(account.level_id == 11){
                    previewRow = '<a href="{{ url("vendor/show-tagihan-vendor")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    btnEdit = `<a href="{{ url("vendor/edit-tagihan-vendor")}}/` + data + `" class="dropdown-item">Edit</a>`;
                }else{
                    previewRow = '<a href="{{ url("request/purchase-order/show")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    btnDelete = '<div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>';
                    btnEdit = '<a href="{{ url("request/purchase-order/edit")}}/` + data + `" class="dropdown-item">Edit</a>';
                }
                return `<div class="d-flex align-items-center">
                            `+ sendMailRow +`
                            ` + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{url('request/purchase-order/print')}}/` + data + `" class="dropdown-item">Download</a>`+btnEdit+``+btnDelete+``
            }
        }];

        let columnTagihanVendor = [{
                name: "No. PO",
                data: "purchase_order_number",
                title: "No. PO",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, {
                name: "Vendor",
                data: "vendor",
                title: "Vendor",
                className: 'text-center',
                render: function(data, type, row) {
                    return data.name ? data.name : '';
                }
            }, {
                data: "id",
                name: "vendor_id",
                title: "Action",
                render: function(data, type, row) {
                    let editRow = '';
                    let sendMailRow = '<a href="javascript:;" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>';
                    let previewRow = '<a href="{{ url("vendor/show-tagihan-vendor")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Tagihan Vendor"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    return `<div class="d-flex align-items-center">
                            ` + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{url('request/purchase-order/print')}}/` + data + `" class="dropdown-item">Download</a><a href="{{ url("vendor/edit-tagihan-vendor")}}/` + data + `" class="dropdown-item">Edit</a>
                            <div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>`
                }
            }];

        var urlInvoice = "{{ url('to-do-list') }}"+"/invoice"+"/Disetujui Bm";
        var urlTandaTerima = "{{ url('to-do-list') }}"+"/receipt"+"/Disetujui Bm";
        var urlLaporanKerusakan = "{{ url('complain/laporan-kerusakan/data-damage') }}";
        var urlTicket = "{{ url('complain/data-ticket') }}";
        var urlWorkOrder = "{{ url('complain/work-order/data-work') }}";
        var urlMaterialRequest = "{{ url('request/material-request/data-material-request') }}";
        var urlPurchaseRequest = "{{ url('request/data-purchase-request') }}";
        var urlPurchaseOrder = "{{ url('request/purchase-order/data-purchase-order') }}";
        var urlVendorInvoice = "{{ url('vendor/data-tagihan-vendor') }}";
        
        

        //BM
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        if(account.level_id == 1){
            let n = 0;
            urlInvoice = "{{ url('to-do-list') }}"+"/invoice"+"/Disetujui KA";
            urlTandaTerima = "{{ url('to-do-list') }}"+"/receipt"+"/Disetujui KA";
            urlWorkOrder =  "{{ url('to-do-list') }}"+"/work-order"+"/Disetujui Warehouse";   
            urlMaterialRequest =  "{{ url('to-do-list') }}"+"/material-request"+"/Disetujui Chief Finance";   
            urlPurchaseRequest =  "{{ url('to-do-list') }}"+"/purchase-request"+"/Disetujui KA";   
            urlPurchaseOrder =  "{{ url('to-do-list') }}"+"/purchase-order"+"/Disetujui KA";   
            urlTicket = "{{ url('to-do-list') }}"+"/ticket"+"/Disetujui KA";   
            urlLaporanKerusakan = "{{ url('to-do-list') }}"+"/damage-report"+"/Disetujui KA";   
            tableSetting('Task Invoice', 'invoice-table', columnsInvoice, urlInvoice);
            tableSetting('Task Tanda Terima', 'tanda-terima-table', columnTandaTerima, urlTandaTerima);
            tableSetting('Task Ticket', 'ticket-table', columnTicket, urlTicket);
            tableSetting('Task Laporan Kerusakan', 'laporan-kerusakan-table', columnLaporanKerusakan, urlLaporanKerusakan);
            tableSetting('Task Work Order', 'work-order-table', columnWorkOrder, urlWorkOrder);
            tableSetting('Task Material Request', 'material-request-table', columnMaterialRequest, urlMaterialRequest);
            tableSetting('Task Purchase Request', 'purchase-request-table', columnPurchaseRequest, urlPurchaseRequest)
            tableSetting('Task Purchase Order', 'purchase-order-table', columnPurchaseOrder, urlPurchaseOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 8 ){
                    Swal.close();
                }
            });
        //KA
        }else if(account.level_id == 2){
            let n = 0;
            urlTandaTerima = "{{ url('to-do-list') }}"+"/receipt"+"/terbuat";
            urlLaporanKerusakan = "{{ url('to-do-list') }}"+"/damage-report"+"/Disetujui KT";
            urlTicket = "{{ url('to-do-list') }}"+"/ticket"+"/on progress";
            urlPurchaseRequest = "{{ url('to-do-list') }}"+"/purchase-request"+"/terbuat";
            urlPurchaseOrder = "{{ url('to-do-list') }}"+"/purchase-order"+"/terbuat";
            
            tableSetting('Task Invoice', 'invoice-table', columnsInvoice, urlInvoice);
            tableSetting('Task Tanda Terima', 'tanda-terima-table', columnTandaTerima, urlTandaTerima);
            tableSetting('Task Ticket', 'ticket-table', columnTicket, urlTicket);
            tableSetting('Task Laporan Kerusakan', 'laporan-kerusakan-table', columnLaporanKerusakan, urlLaporanKerusakan);
            tableSetting('Task Purchase Request', 'purchase-request-table', columnPurchaseRequest, urlPurchaseRequest)
            tableSetting('Task Purchase Order', 'purchase-order-table', columnPurchaseOrder, urlPurchaseOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 6 ){
                    Swal.close();
                }
            });
            //Chief Engineering
        } else if(account.level_id == 6){
            let n = 0;
            urlWorkOrder =  "{{ url('to-do-list') }}"+"/work-order"+"/Terbuat";
            tableSetting('Task Work Order', 'work-order-table', columnWorkOrder, urlWorkOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
        //Warehouse
        }else if(account.level_id == 7){
            let n = 0;  
            urlWorkOrder =  "{{ url('to-do-list') }}"+"/work-order"+"/Disetujui Chief Engineering";   
            tableSetting('Task Work Order', 'work-order-table', columnWorkOrder, urlWorkOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
        //Chief Department
        }else if(account.level_id == 8){
            let n = 0;  
            urlMaterialRequest =  "{{ url('to-do-list') }}"+"/material-request"+"/Terbuat";   
            tableSetting('Task Material Request', 'material-request-table', columnMaterialRequest, urlMaterialRequest)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
            //chieEnginer
        }else if(account.level_id == 9){
            let n = 0; 
            urlInvoice = "{{ url('to-do-list') }}"+"/invoice"+"/Terbuat";
            urlMaterialRequest =  "{{ url('to-do-list') }}"+"/material-request"+"/disetujui chief departement";
            urlTandaTerima = "{{ url('to-do-list') }}"+"/receipt"+"/terbuat";
            urlLaporanKerusakan = "{{ url('to-do-list') }}"+"/damage-report"+"/Disetujui KT";
            urlTicket = "{{ url('to-do-list') }}"+"/ticket"+"/on progress";
            urlPurchaseRequest = "{{ url('to-do-list') }}"+"/purchase-request"+"/terbuat";
            urlPurchaseOrder = "{{ url('to-do-list') }}"+"/purchase-order"+"/terbuat";
            tableSetting('Task Material Request', 'material-request-table', columnMaterialRequest, urlMaterialRequest)
            tableSetting('Task Invoice', 'invoice-table', columnsInvoice, urlInvoice);
            tableSetting('Task Tanda Terima', 'tanda-terima-table', columnTandaTerima, urlTandaTerima);
            tableSetting('Task Ticket', 'ticket-table', columnTicket, urlTicket);
            tableSetting('Task Laporan Kerusakan', 'laporan-kerusakan-table', columnLaporanKerusakan, urlLaporanKerusakan);
            tableSetting('Task Purchase Request', 'purchase-request-table', columnPurchaseRequest, urlPurchaseRequest)
            tableSetting('Task Purchase Order', 'purchase-order-table', columnPurchaseOrder, urlPurchaseOrder)
            urlWorkOrder =  "{{ url('to-do-list/purchase-order/Diverifikasi Admin') }}";
            tableSetting('Task Tagihan Vendor', 'tagihan-vendor-table', columnTagihanVendor, urlWorkOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 2 ){
                    Swal.close();
                }
            });
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 6 ){
                    Swal.close();
                }
            });
        //teknisi
        }else if(account.level_id == 5){
            let n = 0; 
            urlWorkOrder =  "{{ url('to-do-list') }}"+"/work-order"+"/Terbuat";   
            tableSetting('Task Work Order', 'work-order-table', columnWorkOrder, urlWorkOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
        //leader cleaning
        }else if(account.level_id == 4){
            let n = 0; 
            urlLaporanKerusakan = "{{ url('to-do-list') }}"+"/damage-report"+"/Terbuat";
            tableSetting('Task Laporan Kerusakan', 'laporan-kerusakan-table', columnLaporanKerusakan, urlLaporanKerusakan);
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
            //Koordinator
        }else if(account.level_id == 3){
            let n = 0; 
            urlLaporanKerusakan = "{{ url('to-do-list') }}"+"/damage-report"+"/Disetujui LC";
            tableSetting('Task Laporan Kerusakan', 'laporan-kerusakan-table', columnLaporanKerusakan, urlLaporanKerusakan);
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 1 ){
                    Swal.close();
                }
            });
        }else if(account.level_id == 11){
            let vendor = getVendorId(account.email);
            let n = 0;
            urlPurchaseOrder = "{{ url('to-do-list-vendor/purchase-order-vendor') }}/"+vendor.id;
            tableSetting('Task Purchase Order', 'purchase-order-table', columnPurchaseOrder, urlPurchaseOrder, 12)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                console.log(n);
                if(n == 1 ){
                    Swal.close();
                }
            });
        }else{
            urlInvoice = "{{ url('to-do-list') }}"+"/invoice"+"/Disetujui BM"; 
            let n = 0; 
            urlPurchaseOrder = "{{ url('to-do-list/purchase-order/Disetujui Bm') }}";
            tableSetting('Task Invoice', 'invoice-table', columnsInvoice, urlInvoice);
            tableSetting('Task Tanda Terima', 'tanda-terima-table', columnTandaTerima, urlTandaTerima);
            tableSetting('Task Purchase Order', 'purchase-order-table', columnPurchaseOrder, urlPurchaseOrder)
            urlWorkOrder =  "{{ url('to-do-list/purchase-order/Diupload Vendor') }}";
            tableSetting('Task Tagihan Vendor', 'tagihan-vendor-table', columnTagihanVendor, urlWorkOrder)
            $(document).ajaxSuccess(function(){
                n = n + 1;
                if(n == 2 ){
                    Swal.close();
                }
            });
        }
        

    }));

    function getVendorId(email) {
        let result;
        let datas = {}
        datas.email = email;
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/vendor/email',
            type: "POST",
            data: JSON.stringify(datas),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            success: function(response) {
                result = response.data;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text:  xhr?.responseJSON?.message,
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
            }
        });
        return result;
    }

    function closeSwall(){
        Swal.close();
    }

    function tableSetting(title, table, column, url, width=6) {
        let temp = `    
                <div class="col-md-${width} mb-3">
                    <div class="card">
                        <div class="card-datatable table-responsive pt-0">
                            <table class="${table} table">

                            </table>
                        </div>
                    </div>
                </div>`;
        $('#tables').append(temp);
        var invoiceTable = $("." + table);
        if (invoiceTable.length) {
            var dt_project = invoiceTable.DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                async : false,
                ajax: {
                    url: url,
                    "data": function(d) {
                        d.start = 0;
                        d.page = invoiceTable.DataTable().page.info().page + 1;
                    }
                },
                columns: column,
                order: [
                    [0, 'desc']
                ],

                dom: `<"div pt-3 px-3"<"head-label-` + table + `">>` +
                    `<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3">><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>`,

                responsive: {
                    details: {
                       
                        type: 'column',
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                    ?
                                    '<tr data-dt-row="' +
                                    col.rowIndex +
                                    '" data-dt-column="' +
                                    col.columnIndex +
                                    '">' +
                                    '<td>' +
                                    col.title +
                                    ':' +
                                    '</td> ' +
                                    '<td>' +
                                    col.data +
                                    '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ? $('<table class="table"/><tbody />').append(data) : false;
                        }
                    }
                }
            });
            $('div.head-label-' + table).html('<h2 class="card-title mb-0">' + title + '</h2>');
        }
        setTimeout(() => {
            $('.dataTables_filter .form-control').removeClass('form-control-sm');
            $('.dataTables_length .form-select').removeClass('form-select-sm');
        }, 300);
    }
    
    $(document).on('click', '.send-email', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, Kirim!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((result) => {
            if (result.value) {
                let id = $(this).data('id');
                let datas = {}
                datas.status = 'Terkirim';
                Swal.fire({
                    title: 'Memeriksa...',
                    text: "Harap menunggu",
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" + '/api/invoice/update-status/'+id,
                    type: "PATCH",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Mengirim Invoice',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            $(".invoice-table").DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text:  xhr?.responseJSON?.message,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                });
            }
        });
    });

    $(document).on('click', '.send-email-receipt', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, Kirim!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((result) => {
            if (result.value) {
                let id = $(this).data('id');
                let datas = {}
                datas.status = 'Terkirim';
                Swal.fire({
                    title: 'Memeriksa...',
                    text: "Harap menunggu",
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" + '/api/receipt/update-status/'+id,
                    type: "PATCH",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Mengirim Tanda Terima',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            $(".tanda-terima-table").DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text:  xhr?.responseJSON?.message,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                });
            }
        });
    });

    $(document).on('click', '.send-email-po', function(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, Kirim!",
            cancelButtonText: "Batal",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then((result) => {
            if (result.value) {
                let id = $(this).data('id');
                let datas = {}
                datas.status = 'Terkirim';
                Swal.fire({
                    title: 'Memeriksa...',
                    text: "Harap menunggu",
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" + '/api/purchase-order/update-status/'+id,
                    type: "PATCH",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Mengirim Purchase Order',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            $(".purchase-order-table").DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text:  xhr?.responseJSON?.message,
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                });
            }
        });
    });

</script>

@endsection