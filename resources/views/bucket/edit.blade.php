@extends('layouts.master')

@section('content')
            <!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Edit Bucket</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{ route('bucket.list') }}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
				</section>
				<!-- Main content -->
				<section class="content">
					<!-- Default box -->
					<div class="container-fluid">
                        <form id="form" method="POST" name="bucket_form" action="{{ route('bucket.update', $bucket->id) }}">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-body">								
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3 @error('name') has-error @enderror">
                                                <label for="name">Bucket Name</label>
                                                <input type="text" name="name" id="name" required class="form-control" placeholder="Bucket Name" value="{{ old('name', $bucket->name) }}">	
                                                @error('name')
                                                    <label for="name" class="error" style="color:red;">
                                                        <strong>{{ $message }}</strong>
                                                    </label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3 @error('unit') has-error @enderror">
                                                <label for="email">Bucket Unit</label>
                                                <input type="text" name="unit" id="unit" required class="form-control" placeholder="Bucket Unit" value="{{ old('unit', $bucket->unit) }}">	
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
                                <button class="btn btn-primary" type="submit">Update</button>
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