@extends('layouts.app')
@section('content')
<div class="page-min-height" style="background-color: rgb(69, 77, 102)">
	<div class="container">
		<div class="row" style="margin-top: 30px;">
			<div class="col-md-6"></div>
			<div class="col-md-6">
				@if ($message = Session::get('success'))
				<div class="alert alert-success" id="message_id">
					<p>{{ $message }}</p>
				</div>
				@endif
			</div>
		</div>
		<table class="rwd-table">
			<?php 
				$rank = 0;
				$oldScore = '';
			?>
			@foreach($leaderboard as $index=>$leader)
			@if($index==0)
			<h5 style="color: #fff; margin-bottom: 35px;text-align: center;">Score Board for <b><i>{{$leader->title}}</i></b> Quiz: (Total Questions: <b><i>{{ $leader->total_questions}} </i></b>)</h5>
			@endif
			@endforeach
			<tbody>
				<tr>
					<th>Rank</th>
					<th>Name</th>
					<th>Score</th>					
					<th>Appeared on</th>
				</tr>
				@foreach($leaderboard as $index=>$leader)
				<tr>
					<td data-th="Rank">
						 <?php							
						if($oldScore != $leader->avg_score){
							$rank++;
						}
						$oldScore = $leader->avg_score;
					 ?>
					 {{ $rank }}
					<?php
					$userId  = Auth::user()->id;
					if($leader->user_id == $userId){ ?>
						<span style="color:#009975">You</span>
					<?php }

					?>
					</td>
					@if($index==0)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #AF9500; font-size: 20px"></i></td>
					@elseif($index==1)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #B4B4B4; font-size: 20px"></i></td>
					@elseif($index==2)
					<td data-th="Name">{{ $leader->name }} <i class="fa fa-trophy" style="color: #AD8A56; font-size: 20px "></i></td>
					@else
					<td data-th="Name">{{ $leader->name }}</td>
					@endif
					<td data-th="Score">
						<?php echo  number_format($leader->avg_score * 100 / $leader->total_questions,2); ?>%
					</td>					
					<td data-th="Appeared on">
						{{ Carbon\Carbon::parse($leader->updated_at)->format('d-m-Y') }} at {{ Carbon\Carbon::parse($leader->updated_at)->format('g:i A') }}
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$("document").ready(function(){
		setTimeout(function(){
			$("#message_id").remove();
		}, 1000 );
	});
</script>
@endsection