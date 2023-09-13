@extends('layouts.master')

@section('content')
            <!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Create Ball</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('ball.list') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <form id="form" method="POST" name="ball_form" action="{{ route('ball.store') }}">
                            @csrf
                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 @error('name') has-error @enderror">
                                                <label for="name">Ball Name</label>
                                                <input type="text" name="name" id="name" required class="form-control" placeholder="Ball Name">	
                                                @error('name')
                                                    <label for="name" class="error" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 @error('unit') has-error @enderror">
                                                <label for="email">Ball Unit (Cubic Inches)</label>
                                                <input type="text" name="unit" id="unit" required class="form-control" placeholder="Ball Unit">	
                                                @error('unit')
                                                    <label for="unit" class="error" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>									
                                    </div>
                                </div>							
                            </div>
                            <div class="pb-5 pt-3">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <a href="javascript:void(0);" class="btn btn-outline-dark ml-3" onclick="bucket_form.reset();">Cancel</a>
                            </div>
                        </form>
					</div>
					<!-- /.card -->
				</section>
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->
@endsection