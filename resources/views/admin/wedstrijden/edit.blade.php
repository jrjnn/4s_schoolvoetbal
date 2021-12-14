@extends('pages.base')

@section('content')
	<div class="container">
		<h1>Wedstrijd aanpassen</h1>

		@include('fragments.flash-message')

		<form action="{{route('wedstrijden.update', $wedstrijd->id)}}" method="POST"
		      class="w-50 mx-auto">
			@csrf
			@method('PUT')
			<div class="mb-3">
				<label for="title" class="form-label">Titel</label>
				<input type="text" class="form-control" id="title" name="title" value="{{$wedstrijd->title}}">
			</div>

			<div class="row">
				<div class="mb-3 col-5">
					<label for="team1" class="form-label">Team 1</label>
					<select name="team1" id="team1" class="form-select">
						<option value="" selected disabled>-- Team --</option>
						@foreach($teams as $team)
							@if($wedstrijd->team1_id == $team->id)
								<option value="{{$team->id}}" selected>{{$team->teamnaam}}</option>
							@else
								<option value="{{$team->id}}">{{$team->teamnaam}}</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="d-flex justify-content-center align-items-center mb-3 col-2 pt-4 px-auto">
					<span class="text-center">vs.</span>
				</div>

				<div class="mb-3 col-5">
					<label for="team2" class="form-label">Team 2</label>
					<select name="team2" id="team2" class="form-select">
						<option value="" selected disabled>-- Team --</option>
						@foreach($teams as $team)
							@if($wedstrijd->team2_id == $team->id)
								<option value="{{$team->id}}" selected>{{$team->teamnaam}}</option>
							@else
								<option value="{{$team->id}}">{{$team->teamnaam}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>

			<div class="row">
				<div class="mb-3 col-5">
					<label for="score_team1" class="form-label">Score team 1</label>
					<input type="number" class="form-control" name="score_team1" id="score_team1"
					       @if($wedstrijd->is_bewerkt) readonly @endif value="{{$wedstrijd->score_team1}}">
				</div>

				<div class="d-flex justify-content-center align-items-center mb-3 col-2 pt-4 px-auto">
					<span class="text-center">-</span>
				</div>

				<div class="mb-3 col-5">
					<label for="score_team2" class="form-label">Score team 2</label>
					<input type="number" class="form-control" name="score_team2" id="score_team2"
					       @if($wedstrijd->is_bewerkt) readonly @endif value="{{$wedstrijd->score_team2}}">
				</div>
			</div>

			<div class="mb-3">
				<label for="datum" class="form-label">Datum</label>
				<input type="date" class="form-control" name="datum" id="datum"
				       value="{{date('Y-m-d', strtotime($wedstrijd->datum))}}">
			</div>

			<div class="mb-3">
				<label for="scheidsrechter" class="form-label">Scheidsrechter</label>
				<select name="scheidsrechter" id="scheidsrechter" class="form-select">
					<option value="" selected disabled>-- Scheidsrechter --</option>
					@foreach($users as $user)
						@if($wedstrijd->scheidsrechter_id == $user->id)
							<option value="{{$user->id}}" selected>{{$user->name}}</option>
						@else
							<option value="{{$user->id}}">{{$user->name}}</option>
						@endif
					@endforeach
				</select>
			</div>

			<div class="mb-3">
				<label for="locatie" class="form-label">Locatie</label>
				<input type="text" class="form-control" name="locatie" id="locatie" value="{{$wedstrijd->locatie}}">
			</div>

			<div class="mb-3">
				<label for="status" class="form-label">Status</label>
				<input type="text" class="form-control" name="status" id="status" value="{{$wedstrijd->status}}">
			</div>

			<div class="mb-3">
				<input type="submit" onclick="return checkScores()" class="btn btn-primary" value="Opslaan"
				       id="update-match">
			</div>

			<!-- Modal -->
			<div class="modal fade" id="updateScoresModal" tabindex="-1" aria-labelledby="updateScoresModal"
			     aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="updateScoresModalLabel">Scores updaten?</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<p>De uitslag kan maar &eacute;&eacute;n keer ingevuld worden.</p>
							<p><strong>Weet je het zeker?</strong></p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
							<button type="submit" class="btn btn-primary">Opslaan</button>
						</div>
					</div>
				</div>
			</div>

		</form>
	</div>

	<script>
        let scoreTeam1Field = document.getElementById('score_team1');
        let scoreTeam2Field = document.getElementById('score_team2');

        let modal = new bootstrap.Modal(document.getElementById('updateScoresModal'))
        let trigger = document.getElementById('update-match');

        let isEdited = {{json_encode($wedstrijd->is_bewerkt)}};

        function checkScores() {
            if ((scoreTeam1Field.value || scoreTeam2Field.value) && !isEdited) {
                console.log('hoi');

                modal.show();

                trigger.focus()
                event.preventDefault();
                return true;
            } else {
                return true;
            }
        }

	</script>
@endsection
