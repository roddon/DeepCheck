@extends('layouts.app-2')
@section('content')
<div class="row h-100">
	<div class="col-lg-3">
		<div class="dash_main_container sm-hgt h-100">
			<div class="top_title title-small mb-3">Suppliers</div>
			<div class="dash_section_3">
				<div class="table-responsive">
					<table class="table table-borderless invc-tbl">
						<thead>
							<tr>
								<th>Supplier name</th>
							</tr>
						</thead>
						<tbody>
							@foreach($suppliers as $data)
							<tr>
								<td class="micro psar {{request('supplier_id') == $data->id ? 'active' : ''}}">
									<a class="d-flex align-items-center" href="{{ route('sVault.supplier.verification', ['supplier_id' => $data->id]) . '?page=' . request()->get('page') ?? 1 }}">
										<img src="{{ asset('assets/img/micro_icon.png') }}" alt=""> {{$data->present()->name}}
										<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="dataTables_paginate newdata">
					{{ $suppliers->links('vendor.pagination.default') }}

				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-9">
		<div class="dash_main_container sm-hgt mt-mbl h-100">
			<ul class="upperul">
				<li id="invoice-varification" class='active'><a href="javascript:void(0);">Invoice verification</a></li>
				<li id="supplier-varification"><a href="javascript:void(0);">Supplier verification</a></li>
				<div class="right-actions float-right">
                    <a href="javascript:void(0);" id="listView"><img src="{{asset('assets/images/list.png')}}" title="list" width="20"/></a>
                    <a href="javascript:void(0);" id="gridView"><img src="{{asset('assets/images/grid.png')}}" title="grid" width="20"/></a>
                </div>
			</ul>
			@include('manage.suppliers.invoice-varification')
			@include('manage.suppliers.supplier-verification')
		</div>
	</div>
</div>

@include('manage.suppliers.invite-supplier-modal')
@endsection

@section('scripts')


<script>
	$('#inviteSupplierForVerification').click(function() {
		$('#invite-supplier').modal('show');
	});

	$('#sendInvitaion').click(function() {

		company_name = $.trim($('#company_name').val());
		lastname = $.trim($('#lastname').val());
		email = $.trim($('#email').val());

		if (company_name == '') {
			$('#company_name').focus()
			$('#error_onboarding_invite').html('<span class="alert alert-danger">Please enter company name</span>')
			return false;
		} else if (email == '') {
			$('#email').focus()
			$('#error_onboarding_invite').html('<span class="alert alert-danger">Please valid email</span>')
			return false;
		}
		$('#overlay').fadeIn();
		$('#invite-supplier').hide();
		$('#frmInviteCustomer').submit();
	});

	$('#invoice-varification').click(function() {
		$('.right-actions').show();
		$('#gridViewArea').show();
        $('#listViewArea').hide();
		$('#supplier-varification').removeClass('active');
		$('#invoice-varification').addClass('active');

		$('#invoice-varification-area').show();
		$('#supplier-varification-area').hide();
	})

	$('#supplier-varification').click(function() {
		$('.right-actions').hide();
		$('#supplier-varification').addClass('active');
		$('#invoice-varification').removeClass('active');

		$('#invoice-varification-area').hide();
		$('#supplier-varification-area').show();
	})

	$('#gridView').click(function() {
        $('#listViewArea').hide();
        $('#gridViewArea').show();
    })

    $('#listView').click(function() {
        $('#gridViewArea').hide();
        $('#listViewArea').show();
    })

	// @if($invoiceVerification)
	// $('#invoice-varification').trigger('click');
	// @else
	// $('#supplier-varification').trigger('click');
	// @endif

	$('a[name^=a_invoices]').click(function() {
		invoice_id = $(this).attr('invoice_id');
		$('a[name^=a_invoices]').removeClass('bdrClr');
		$(this).addClass('bdrClr');
		$.ajax({
			url: "{{route('sVault.supplier.invoice.detail')}}",
			type: 'POST',
			data: {
				'invoice_id': invoice_id,
			},
			success: function(result) {
				$('#invoice_area').html(result);
				$('#overlay').fadeOut();
			},
			error: function(result) {
				$('#overlay').fadeOut();
				swal("Oops..", result.responseJSON.message, "error");
			},
			beforeSend: function() {
				$('#overlay').fadeIn();
			},
			complete: function() {
				$('#overlay').fadeOut();
			}
		});
	})
</script>
@endsection