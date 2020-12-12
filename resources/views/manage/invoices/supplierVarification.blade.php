@extends('layouts.app')
@section('styles')
 <link rel='stylesheet' href='https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css'>
 <link rel='stylesheet' href='https://cdn.datatables.net/responsive/1.0.4/css/dataTables.responsive.css'>
 <link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css">
 <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
@endsection
@section('content')
<div class="dash_main">
	<div class="row">
	    <div class="col-lg-3">	
		 	<div class="dash_main_container sm-hgt">
			    <div class="top_title">Suppliers</div>
			    <div class="dash_section_3">
				    <div class="table-responsive">
                        <table class="table table-borderless invc-tbl">
                            <thead>
                                <tr>
                                    <th>Supplier name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td class="micro psar active">
                                        <a class="d-flex align-items-center" href="javascript:void(0);">
                                            <img src="assets/img/micro_icon.png" alt=""> {{$supplier->name}} 
                                            <span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="dataTables_paginate newdata" >
                    {{ $suppliers->links() }}
                        <!-- <ul class="pagination">
                            <li class="paginate_button previous"><a href="#">Previous</a></li>
                            <li class="paginate_button active"><a href="#">1</a></li>
                            <li class="paginate_button "><a href="#">2</a></li>
                            <li class="paginate_button "><a href="#">3</a></li>
                            <li class="paginate_button "><a href="#">4</a></li>
                            <li class="paginate_button next" ><a href="#">Next</a></li>
                        </ul> -->
                    </div>
			    </div>
		    </div>
		</div>
		<div class="col-lg-9">
		 	<div class="dash_main_container sm-hgt mt-mbl">
                <ul class="upperul">	
                    <li><a href="javascript:void(0);">Invoice verification</a></li>
                    <li class="active"><a href="javascript:void(0);">Supplier verification</a></li>
                </ul>
			 	<div class="inrcontsec">
			 		<div class="overfldv">
			 		  	<ul class="splrnm">
			 		  	 	<li>
			 		  	 		<span class="dv"><b>Supplier Name</b></span>
			 		  	 		<span class="dv">Account holder <span class="brk">Company number</span>  <span class="brk">VAT number</span></span>
			 		  	 		<span class="dv light">Lorem ipsum dolor visi <span class="brk"> 3433434343434343 </span> <span class="brk red">MISSING</span> </span>
			 		  	 		<span class="dv mr-0"> <span class="veri">Verified </span> <span class="veri">Verified </span> <span class="veri faild">FAILED </span></span>
			 		  	 	</li>
			 		  	 	<li>
			 		  	 		<span class="dv"><b>Address</b></span>
			 		  	 		<span class="dv">Address 1 <span class="brk">Address 2</span>  <span class="brk">Post code/Zip</span> <span class="brk">City</span> <span class="brk">Country</span></span>
			 		  	 		<span class="dv light">Lorem ipsum dolor visi <span class="brk"> Lorem ipsum dolor visi </span> <span class="brk">Lorem ipsum dolor visi</span> <span class="brk">Lorem ipsum dolor visi</span> <span class="brk">Lorem ipsum dolor visi</span> </span>
			 		  	 		<span class="dv mr-0"> <span class="veri">Verified </span> <span class="veri">Verified </span> <span class="veri">Verified </span> 
			 		  	 		<span class="veri">Verified </span> <span class="veri">Verified </span></span>
			 		  	 	</li>
			 		  	 	<li>
			 		  	 		<span class="dv"><b>Contact</b></span>
			 		  	 		<span class="dv">Email <span class="brk">Phone number</span>  </span>
			 		  	 		<span class="dv light">ernie@microsoft.com <span class="brk"> 020-123456547897 </span>  </span>
			 		  	 		<span class="dv mr-0"> <span class="veri">Verified </span> <span class="veri">Verified </span> </span>
			 		  	 	</li>
			 		  	 	<li>
			 		  	 		<span class="dv"><b>Bank</b></span>
			 		  	 		<span class="dv">Bank name <span class="brk">IBAN</span>  <span class="brk">Sort Code</span> <span class="brk">Account number</span> </span>
			 		  	 		<span class="dv light">HSBC <span class="brk"> GB123GB123G32 </span> <span class="brk">12-34-56</span> <span class="brk">GB123GB123G32</span>  </span>
			 		  	 		<span class="dv mr-0"> <span class="veri">Verified </span> <span class="veri">Verified </span> <span class="veri">Verified </span> 
			 		  	 		<span class="veri">Verified </span> </span>
			 		  	 	</li>
			 		  	 </ul>
			 		</div>
                    <div class="text-center mt-5">
                        <p>Verification failed in one or more areas. Please call your supplier to make sure it was added correctly.</p>
                        <a href="javascript:void(0);" class="invite mt-md-5 mt-3">Invite company for verification</a>
                    </div>
                </div>
		 	</div>
		</div>
	</div>
</div>
@endsection

@section('scripts')
    <script src='https://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js'></script>
    <script src='https://cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.js'></script>
    <script src='https://cdn.datatables.net/responsive/1.0.4/js/dataTables.responsive.js'></script>
@endsection