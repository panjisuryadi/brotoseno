<ul>
@foreach($childs as $child)
    <li>
        <span class="text-dark">&nbsp;{{ $child->name }}</span>
       <!-- <span class="badge badge-circle badge-danger mb-1"> {{ $child->id }}</span> -->
       @if(count($child->childs))
            <ul>
            @foreach($child->childs as $child2)
                <li>
                    <span class="text-dark">&nbsp;{{ $child2->name }}</span>
                <!-- <span class="badge badge-circle badge-danger mb-1"> {{ $child2->id }}</span> -->
                @if(count($child2->childs))
                    <ul>
                        @foreach($child2->childs as $child3)
                            <li>
                                <span class="text-dark">&nbsp;{{ $child3->name }}</span>

                            @if(count($child3->childs))
                                <ul>
                                @foreach($child3->childs as $child4)
                                    <li>
                                        <span class="text-dark">&nbsp;{{ $child4->name }}</span>
                                    <!-- <span class="badge badge-circle badge-danger mb-1"> {{ $child->id }}</span> -->
                                    </li>
                                @endforeach
                                </ul>
                            @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
                </li>
            @endforeach
            </ul>
        @endif
    </li>
@endforeach
</ul>