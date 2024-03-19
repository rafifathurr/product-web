<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body>
    @csrf
    <div class="wrapper">
        @include('layouts.sidebar')
        <div class="main-panel">
            <div class="content">
                <div class="panel-header">
                    <div class="page-inner py-5">
                        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                            <div>
                                <h2 class="pb-2 fw-bold">{{ $title }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner mt--5">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><b>Jumlah User</b></div>
                                </div>
                                <div class="card-body">
                                    <div class="row p-3">
                                        <h2 style="text-align:right;" id="counter_all">{{ $total_user }} <span>User</span></h2> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><b>Jumlah User Aktif</b></div>
                                </div>
                                <div class="card-body">
                                    <div class="row p-3">
                                        <h2 style="text-align:right;" id="counter_all">{{ $total_user_active }} <span>User</span></h2> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><b>Jumlah Produk</b></div>
                                </div>
                                <div class="card-body">
                                    <div class="row p-3">
                                        <h2 style="text-align:right;" id="counter_all">{{ $total_product }} <span>Produk</span></h2> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title"><b>Jumlah Produk Aktif</b></div>
                                </div>
                                <div class="card-body">
                                    <div class="row p-3">
                                        <h2 style="text-align:right;" id="counter_all">{{ $total_product_active }} <span>Produk</span></h2> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</body>

</html>
