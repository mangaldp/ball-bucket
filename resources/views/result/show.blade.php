@extends('layouts.master')

@section('content')

        <!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Bucket Suggestion Result</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('result.list') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">	
                                        <h2 class="h4 mb-3">Balls Input</h2>							
                                        <div class="row mb-3">
                                            @foreach($raw as $k => $ball)
                                            @php
                                                $part = explode('-',$ball);
                                            @endphp
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="ball">{{$k}} - {{$part[0]}} Cubic Inches</label>
                                                    <input type="text" readonly class="form-control" value="{{$part[1]}}">
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>	                                                                      
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header pt-3">
                                        <div class="row invoice-info">
                                            <div class="col-sm-4 invoice-col">
												<h1 class="h5 mb-3">Result</h1>
												<address>
													Following are the suggested bucket:
												</address>
                                            </div>

                                            <div class="col-sm-4 invoice-col bkt_avl">
                                                <h1 class="h5 mb-3">Bucket Available</h1>
                                                @if(!empty($empty))
                                                @foreach($empty as $k => $empt)
                                                    <b>"{{$k}}" bucket is empty by {{$empt}} cubic inches</b><br>
                                                @endforeach
                                                @endif
                                            </div>
                                            <div class="col-sm-4 invoice-col bal_avl">
                                                <h1 class="h5 mb-3">Extra Balls</h1>
                                                @if(!empty($extra))
                                                @foreach($extra as $k => $ext)
                                                    <b> {{$k}} ball is extra by {{$ext}} number</b><br>
                                                @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-3 mb-3">								
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="150">Bucket</th>
                                                    <th>Ball Details</th>                                        
                                                </tr>
                                            </thead>
                                            <tbody class="bkt_data">
                                            @foreach($fill as $k => $fldt)
                                            <tr>
                                                <td> Bucket {{$k}}:</td>
                                                <td>
                                                Place 
                                                @foreach($fldt as $b => $nm)
                                                     {{$nm}} {{$b}} balls, 
                                                @endforeach
                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>								
                                    </div>                         
                                </div>
                            </div>
                        </div>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>
		<!-- /.content-wrapper -->

@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $('.datatable').DataTable();
});
</script>
@endsection