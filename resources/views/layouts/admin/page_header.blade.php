<!-- Page header -->
<div class="mb-6">
    @php
        $url = '/admin/dashboard';
    @endphp
    <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ $url }}"> <i class="bi bi-house me-1"></i>Dashboard</a></li>
          @foreach($breadcrumb as $bk=>$bv)
          <li class="breadcrumb-item active"><a href="{{$bk}}">{{$bv}}</a></li>
          @endforeach
        </ol>
    </nav>
</div>
<!-- /page header -->
