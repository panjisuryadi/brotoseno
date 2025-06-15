<div class="modal fade" id="tracking-modal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-lg font-bold" id="addModalLabel">History Tracking Nota</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="bg-white px-4 overflow-hidden py-2">

                    <div class="flex justify-between px-1 py-3 border px-4 rounded">
                        <div class="text-gray-600">
                            <div>Invoice: <strong>{{ $nota->invoice }}</strong></div>
                            <div>Tanggal: <strong> {{ \Carbon\Carbon::parse($nota->date)->format('d M, Y') }}</strong></div>
                        </div>
                        <div class="text-gray-600">
                            <div>Cabang: <strong>{{ $nota->cabang->name ?? '-' }}</strong></div>
                            <div>
                                Dibuat oleh: <strong>{{ $nota->pic->name ?? '-' }}</strong>
                            </div>
                        </div>

                    </div>

                    <div class="w-full  mx-auto relative py-0">

                        <div class="border-l-2 mt-2">
                            <!-- Card 1 -->
                            @foreach ($nota->history as $history )
                            <div class="transform transition cursor-pointer hover:-translate-y-2 ml-10 relative flex items-center px-6 py-2 @if ($loop->iteration % 2 == 0)
                            bg-blue-300
                            @else
                            bg-green-300
                            @endif text-white rounded mb-3 flex-col md:flex-row space-y-4 md:space-y-0">
                                <!-- Dot Follwing the Left Vertical Line -->
                                <div class="w-5 h-5 bg-blue-300 absolute -left-10 transform -translate-x-2/4 rounded-full z-10 mt-2 md:mt-0"></div>
                                <div class="w-10 h-1 bg-blue-300 absolute -left-10 z-0"></div>
                                <div class="justify-self-stretch gap-3">
                                    <div style="font-size: 0.7rem;" class="text-left text-gray-900">{{ \Carbon\Carbon::parse($history->date)->format('d M, Y') }}</div>
                                    <div class="font-normal text-left leading-5 text-gray-800">
                                        Status Barang : <span class="uppercase">{{ $history->status->name }}</span>
                                    </div>
                                    <div class="font-normal text-left leading-5 text-gray-800">
                                        PIC : <span class="uppercase font-bold">{{ $history->pic->name }}</span>
                                    </div>

                                </div>

                            </div>
                            @endforeach


                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@push('page_scripts')
<script>


</script>
@endpush