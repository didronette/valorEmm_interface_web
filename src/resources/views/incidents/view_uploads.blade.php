@extends('templatePage')

@section('titre')
    View upload
@endsection

@section('contenu')
  
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th class="cs-p-1">Name</th>
                <th class="cs-p-1">URL</th>
            </tr>
        </thead>

        @forelse($images as $image)
            <tr>
                <td class="cs-p-1">{{ $image->nom }}</td>
                <td class="cs-p-1"><a href="{{ $image->url }}">View Image</a></td>
            </tr>
            @empty
            <p>No Images at the moment</p>
        @endforelse
    </table>
</div>
@endsection