<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ env('APP_NAME') }} - {{ env('APP_DESC') }}">
    <meta name="author" content="{{ env('APP_AUTHOR') }}">
    <meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
    
    <title>{{ config('app.name') }}</title>
    
    <!-- color-modes:js -->
    <script src="{{ asset('/') }}assets/js/color-modes.js"></script>
    <!-- endinject -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="{{ asset('/') }}../../../fonts.googleapis.com/index.html">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&amp;display=swap" rel="stylesheet">
    <!-- End fonts -->
    
    <!-- core:css -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/core/core.css">
    <!-- endinject -->
    
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/') }}assets/vendors/flatpickr/flatpickr.min.css">
    <!-- End plugin css for this page -->
    
    <!-- inject:css -->
    <!-- endinject -->
    
    <!-- Layout styles -->  
    <link rel="stylesheet" href="{{ asset('/') }}assets/css/demo1/style.css">
    <!-- End layout styles -->
    
    <link rel="shortcut icon" href="{{ asset('/') }}assets/images/favicon.png" />
    
</head>
<body>
    <div class="main-wrapper">
        
        <!-- partial:partials/_sidebar.html -->
        <x-sidebar />
        <!-- partial -->
        
        <div class="page-wrapper">
            
            <!-- partial:partials/_navbar.html -->
            <x-navbar />
            <!-- partial -->
            
            <div class="page-content container-xxl">
                
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
                    </div>
                    <div class="d-flex align-items-center flex-wrap text-nowrap">
                        <div class="input-group flatpickr w-200px me-2 mb-2 mb-md-0" id="dashboardDate">
                            <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-lucide="calendar" class="text-primary"></i></span>
                            <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-lucide="printer"></i>
                            Print
                        </button>
                        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                            <i class="btn-icon-prepend" data-lucide="download-cloud"></i>
                            Download Report
                        </button>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12 col-xl-12 stretch-card">
                        <div class="row flex-grow-1">
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h6 class="card-title mb-0">New Customers</h6>
                                            <div class="dropdown mb-2">
                                                <a type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-5">
                                                <h3 class="mb-2">3,897</h3>
                                                <div class="d-flex align-items-baseline">
                                                    <p class="text-success">
                                                        <span>+3.3%</span>
                                                        <i data-lucide="arrow-up" class="icon-sm mb-1"></i>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h6 class="card-title mb-0">New Orders</h6>
                                            <div class="dropdown mb-2">
                                                <a type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-5">
                                                <h3 class="mb-2">35,084</h3>
                                                <div class="d-flex align-items-baseline">
                                                    <p class="text-danger">
                                                        <span>-2.8%</span>
                                                        <i data-lucide="arrow-down" class="icon-sm mb-1"></i>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <h6 class="card-title mb-0">Growth</h6>
                                            <div class="dropdown mb-2">
                                                <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 col-md-12 col-xl-5">
                                                <h3 class="mb-2">89.87%</h3>
                                                <div class="d-flex align-items-baseline">
                                                    <p class="text-success">
                                                        <span>+2.8%</span>
                                                        <i data-lucide="arrow-up" class="icon-sm mb-1"></i>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-12 col-xl-7">
                                                <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
                
                <div class="row">
                    <div class="col-12 col-xl-12 grid-margin stretch-card">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                                    <h6 class="card-title mb-0">Revenue</h6>
                                    <div class="dropdown">
                                        <a type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-start">
                                    <div class="col-md-7">
                                        <p class="text-secondary fs-13px mb-3 mb-md-0">Revenue is the income that a business has from its normal business activities, usually from the sale of goods and services to customers.</p>
                                    </div>
                                    <div class="col-md-5 d-flex justify-content-md-end">
                                        <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-primary">Today</button>
                                            <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
                                            <button type="button" class="btn btn-primary">Month</button>
                                            <button type="button" class="btn btn-outline-primary">Year</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="revenueChart"></div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
                
                <div class="row">
                    <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0">Monthly sales</h6>
                                    <div class="dropdown mb-2">
                                        <a type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-secondary">Sales are activities related to selling or the number of goods or services sold in a given time period.</p>
                                <div id="monthlySalesChart"></div>
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Cloud storage</h6>
                                    <div class="dropdown mb-2">
                                        <a type="button" id="dropdownMenuButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="storageChart"></div>
                                <div class="row mb-3">
                                    <div class="col-6 d-flex justify-content-end">
                                        <div>
                                            <label class="d-flex align-items-center justify-content-end fs-10px text-uppercase fw-bolder">Total storage <span class="p-1 ms-1 rounded-circle bg-secondary"></span></label>
                                            <h5 class="fw-bolder mb-0 text-end">8TB</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <label class="d-flex align-items-center fs-10px text-uppercase fw-bolder"><span class="p-1 me-1 rounded-circle bg-primary"></span> Used storage</label>
                                            <h5 class="fw-bolder mb-0">~5TB</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary">Upgrade storage</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- row -->
                
                <div class="row">
                    <div class="col-lg-5 col-xl-4 grid-margin grid-margin-lg-0 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0">Inbox</h6>
                                    <div class="dropdown mb-2">
                                        <a type="button" id="dropdownMenuButton6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="javascript:;" class="d-flex align-items-center border-bottom pb-3">
                                        <div class="me-3">
                                            <img src="{{ asset('/') }}assets/images/faces/face2.jpg" class="rounded-circle w-35px" alt="user">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-body mb-2">Leonardo Payne</h6>
                                                <p class="text-secondary fs-12px">12.30 PM</p>
                                            </div>
                                            <p class="text-secondary fs-13px">Hey! there I'm available...</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                                        <div class="me-3">
                                            <img src="{{ asset('/') }}assets/images/faces/face3.html" class="rounded-circle w-35px" alt="user">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-body mb-2">Carl Henson</h6>
                                                <p class="text-secondary fs-12px">02.14 AM</p>
                                            </div>
                                            <p class="text-secondary fs-13px">I've finished it! See you so..</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                                        <div class="me-3">
                                            <img src="{{ asset('/') }}assets/images/faces/face4.jpg" class="rounded-circle w-35px" alt="user">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-body mb-2">Jensen Combs</h6>
                                                <p class="text-secondary fs-12px">08.22 PM</p>
                                            </div>
                                            <p class="text-secondary fs-13px">This template is awesome!</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                                        <div class="me-3">
                                            <img src="{{ asset('/') }}assets/images/faces/face5.html" class="rounded-circle w-35px" alt="user">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-body mb-2">Amiah Burton</h6>
                                                <p class="text-secondary fs-12px">05.49 AM</p>
                                            </div>
                                            <p class="text-secondary fs-13px">Nice to meet you</p>
                                        </div>
                                    </a>
                                    <a href="javascript:;" class="d-flex align-items-center border-bottom py-3">
                                        <div class="me-3">
                                            <img src="{{ asset('/') }}assets/images/faces/face6.jpg" class="rounded-circle w-35px" alt="user">
                                        </div>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                                                <p class="text-secondary fs-12px">01.19 AM</p>
                                            </div>
                                            <p class="text-secondary fs-13px">Hey! there I'm available...</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-xl-8 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline mb-2">
                                    <h6 class="card-title mb-0">Projects</h6>
                                    <div class="dropdown mb-2">
                                        <a type="button" id="dropdownMenuButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="icon-lg text-secondary pb-3px" data-lucide="more-horizontal"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                            <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-lucide="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="pt-0">#</th>
                                                <th class="pt-0">Project Name</th>
                                                <th class="pt-0">Start Date</th>
                                                <th class="pt-0">Due Date</th>
                                                <th class="pt-0">Status</th>
                                                <th class="pt-0">Assign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>NobleUI jQuery</td>
                                                <td>01/01/2025</td>
                                                <td>26/04/2025</td>
                                                <td><span class="badge bg-danger">Released</span></td>
                                                <td>Leonardo Payne</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>NobleUI Angular</td>
                                                <td>01/01/2025</td>
                                                <td>26/04/2025</td>
                                                <td><span class="badge bg-success">Review</span></td>
                                                <td>Carl Henson</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>NobleUI ReactJs</td>
                                                <td>01/05/2025</td>
                                                <td>10/09/2025</td>
                                                <td><span class="badge bg-info">Pending</span></td>
                                                <td>Jensen Combs</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>NobleUI VueJs</td>
                                                <td>01/01/2025</td>
                                                <td>31/11/2025</td>
                                                <td><span class="badge bg-warning">Work in Progress</span>
                                                </td>
                                                <td>Amiah Burton</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>NobleUI Laravel</td>
                                                <td>01/01/2025</td>
                                                <td>31/12/2025</td>
                                                <td><span class="badge bg-danger">Coming soon</span></td>
                                                <td>Yaretzi Mayo</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>NobleUI NodeJs</td>
                                                <td>01/01/2025</td>
                                                <td>31/12/2025</td>
                                                <td><span class="badge bg-primary">Coming soon</span></td>
                                                <td>Carl Henson</td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom">3</td>
                                                <td class="border-bottom">NobleUI EmberJs</td>
                                                <td class="border-bottom">01/05/2025</td>
                                                <td class="border-bottom">10/11/2025</td>
                                                <td class="border-bottom"><span class="badge bg-info">Pending</span></td>
                                                <td class="border-bottom">Jensen Combs</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div> <!-- row -->
                
            </div>
            
            <!-- partial:partials/_footer.html -->
            <x-footer />
            <!-- partial -->
            
        </div>
    </div>
    
    <!-- core:js -->
    <script src="{{ asset('/') }}assets/vendors/core/core.js"></script>
    <!-- endinject -->
    
    <!-- Plugin js for this page -->
    <script src="{{ asset('/') }}assets/vendors/flatpickr/flatpickr.min.html"></script>
    <script src="{{ asset('/') }}assets/vendors/apexcharts/apexcharts.min.html"></script>
    <!-- End plugin js for this page -->
    
    <!-- inject:js -->
    <script src="{{ asset('/') }}assets/js/app.js"></script>
    <!-- endinject -->
    
    <!-- Custom js for this page -->
    <script src="{{ asset('/') }}assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>
</html>    