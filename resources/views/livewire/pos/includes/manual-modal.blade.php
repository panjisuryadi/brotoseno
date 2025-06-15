<!-- Button trigger Discount Modal -->
<button
role="button"
data-toggle="modal"
data-target="#manualModal"
class="flex flex-row hover:no-underline hover:text-red-400 text-gray-500 px-3 text-center items-center">
<i class="hover:text-red-400 text-2xl text-gray-500 bi bi-pencil-square"></i>
<div class="mb-1 ml-1 lg:text-sm md:text-sm text-xl py-0 font-semibold">Manual</div>
</button>
<!-- manual Modal -->
<div wire:ignore.self class="modal fade" id="manualModal" tabindex="-1" role="dialog" aria-labelledby="manualModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h2 class="text-lg modal-title" id="manualModalLabel">
				<strong>Manual </strong>
				</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if (session()->has('manual'))
			<div class="px-3">
				<div class="alert alert-warning alert-dismissible fade show" role="alert">
					<div class="alert-body">
						<span>{{ session('manual') }}</span>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">×</span>
						</button>
					</div>
				</div>
			</div>
			@endif
@if($cart_items->isNotEmpty())

			<form wire:submit.prevent="setManualtype()" method="POST">
				<div class="modal-body justify-start">
					<div class="form-group text-left">
						<label class="text-left" for="keterangan">Keterangan <span class="text-danger">*</span>
					</label>

					<input id="manual_item" wire:model="manual_item" type="text"
					class="form-control"
					value="{{ $cart_items->first()->options->manual_item }}" name="manual_item">

				</div>
				<div class="form-group text-left">
					<label class="text-left" for="nominal">Nominal <span class="text-danger">*</span>
				</label>

				<input id="manual_price" wire:model="manual_price" type="text"
				class="form-control"
				value="{{ $cart_items->first()->options->manual_price }}" name="manual_price">

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			<button type="submit" class="btn text-white bg-red-400">Save changes</button>
		</div>
	</form>


@else

<div class="card h-200">

<div class="flex justify-content-center items-center">

<div class="text-gray-500">

Anda Belum Memilih Produk

</div>

</div>


</div>

@endif

</div>
</div>
</div>