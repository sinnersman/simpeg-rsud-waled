@extends('layouts.app', compact('title', 'breadcrumbs'))

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Struktur Organisasi Jabatan</h4>
                <p class="text-muted mb-3">Visualisasi hierarki jabatan dalam organisasi.</p>

                <div id="tree"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
{{-- OrgChart.js CSS --}}
<style>
    html, body {
        margin: 0px;
        padding: 0px;
        font-family: Helvetica;;
        overflow: hidden;
    }
    #tree {
        width: 100%;
        height: 700px;
    }
</style>
@endpush

{{-- OrgChart.js JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/orgchart.js@8.0.0/dist/orgchart.js"></script>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log(@json($chartData)); // Debugging line
        var chart = new OrgChart(document.getElementById("tree"), {
            template: "ula", // You can choose different templates
            enableDrag: false,
            enableSearch: false,
            nodeBinding: {
                field_0: "name",
                field_1: "title"
            },
            nodes: @json($chartData)
        });
    });
</script>
@endpush