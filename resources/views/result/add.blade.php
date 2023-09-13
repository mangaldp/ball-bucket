@extends('layouts.master')

@section('content')

        <!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">					
					<div class="container-fluid my-2">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Bucket Suggestion</h1>
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
                                        <h2 class="h4 mb-3">Balls Available</h2>							
                                        <div class="row mb-3">
                                            @if(!empty($balls) && !empty($buckets))
                                            @foreach($balls as $ball)
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="ball_{{$ball->id}}">{{$ball->name}} - {{$ball->unit}} Cubic Inches</label>
                                                    <input type="text" name="ball_{{$ball->id}}" id="ball_{{$ball->id}}" data-ballid="{{$ball->id}}" class="form-control ball_count" placeholder="Enter Number of Balls">	
                                                    <label for="ball_{{$ball->id}}" class="error ball_{{$ball->id}}" style="color:red; display:none;">
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            @if(!empty($buckets))
                                            <div class="col-md-12">
                                                <a href="{{ route('bucket.add') }}" class="btn btn-primary">Add New Bucket</a>
                                            </div>
                                            @endif
                                            @if(!empty($balls))
                                            <div class="col-md-12">
                                                <a href="{{ route('ball.add') }}" class="btn btn-primary">Add New Ball</a>
                                            </div>
                                            @endif
                                            @endif
                                        </div>
                                        <div class="mb-3 text-right">
                                            <button class="btn btn-primary get_result">Place Balls In Bucket</button>
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
                                            </div>
                                            <div class="col-sm-4 invoice-col bal_avl">
                                                <h1 class="h5 mb-3">Extra Balls</h1>
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
                                            </tbody>
                                        </table>								
                                    </div>
                                    <div class="mb-3 text-center">
                                        <form name="result_form" id="result_form" method="post" action="{{ route('result.store') }}">
                                            @csrf
                                            <div class="new_data" style="display: none;"></div> 
                                            <button class="btn btn-primary sv_rslt" type="submit">Save Result</button>
                                        </form>
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
    var result = [];
    $('.get_result').on('click', function(){
        let ball_arr = [];
        $('.ball_count').each(function(i, item){
            if($(this).val() != '' && $(this).val().match(/^[0-9]+$/)){
                ball_arr[$(this).data('ballid')] = $(this).val();
            }
        });

        if(ball_arr.length > 0){
            $('.bkt_data').html('');
            $('.new_data').html('');
            $('.bkt_avl').html('<h1 class="h5 mb-3">Bucket Available</h1>');
            $('.bal_avl').html('<h1 class="h5 mb-3">Extra Balls</h1>');
            $.ajax({
                url: "{{route('result.calculate')}}",
                type: 'POST',
                data: JSON.stringify(ball_arr),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(data){
                    let fl = data.fill;
                    let em = data.empty;
                    let ex = data.extra;
                    let inp = data.input;
                    $.each(fl, function(i, bkt){
                        let tbl_data = '<tr><td> Bucket '+i+':</td><td>';
                        let cont = '';
                        $.each(bkt, function(c,item){
                            if(cont != ''){
                                cont += ' and '
                            }else{
                                cont = 'Place ';
                            }
                            cont += item+' '+c+' balls';
                            let inp = '<input type="text" name="fill['+i+']['+c+']" value="'+item+'">';
                            $('.new_data').append(inp);
                        });
                        tbl_data += cont+'</td></tr>'
                        $('.bkt_data').append(tbl_data);
                    });
                    if(em != ''){
                        let emty = '';
                        $.each(em,function(k, emt){
                            $.each(emt, function(i,itm){
                                if(emty != ''){
                                    emty += '<br>';
                                }
                                emty += '<b>"'+i+'" bucket is empty by '+itm+' cubic inches.</b>';
                                let inp = '<input type="text" name="empty['+i+']" value="'+itm+'">';
                                $('.new_data').append(inp);
                            });
                        });
                        $('.bkt_avl').append(emty);
                    }
                    $.each(ex, function(e, bl){
                        let ex_bl = '';
                        if(bl.qty > 0){
                            ex_bl += '<b>"'+bl.name+'" ball is extra by '+bl.qty+' numbers.</b><br>';
                            let inp = '<input type="text" name="extra['+bl.name+']" value="'+bl.qty+'">';
                            $('.new_data').append(inp);
                        }
                        $('.bal_avl').append(ex_bl);
                    });

                    $.each(inp, function(t, bl){
                        let inp = '<input type="text" name="raw['+bl.name+']" value="'+bl.unit+'-'+bl.qty+'">';
                        $('.new_data').append(inp);
                    });
                },
                error: function(data){
                    alert(data);
                }
            });
        }else{
            alert('Please provide ball quantity');
        }
    });

    $('.ball_count').keydown(function(){
        let id = $(this).data('ballid');
        if($(this).val() != '' && !$(this).val().match(/^[0-9]+$/)){
            $('.ball_'+id).html('<strong>Please enter a valid number.</strong>');
            $('.ball_'+id).show();
        }else{
            $('.ball_'+id).html('');
            $('.ball_'+id).hide();
        }
    });

    $('.sv_rslt').on('click', function(e){
        e.preventDefault();
        if($('#result_data').val()!= ''){
            $('#result_form').submit();
        }else{
            return false;
        }
    });
});
</script>
@endsection