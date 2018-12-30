<div class="page-header page-header-default">
	<div class="page-header-content">
		<div class="page-title">
			<h4><i class="icon-arrow-left52 position-left" onclick="goBack()"></i> <span class="text-semibold">{{isset($brc_main) ? $brc_main : ""}}</span> - {{isset($brc_active) ? $brc_active : ""}}</h4>
		<a class="heading-elements-toggle"><i class="icon-more"></i></a></div>
	</div>

	<div class="breadcrumb-line"><a class="breadcrumb-elements-toggle"><i class="icon-menu-open"></i></a>
		<ul class="breadcrumb">
			<li><a href="{{route('index')}}"><i class="icon-home2 position-left"></i> Home</a></li>
			<li class="active">{{isset($brc_active) ? $brc_active : ""}}</li>
		</ul>

		
	</div>
</div>