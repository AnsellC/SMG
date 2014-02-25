@extends('layout.default')
@section('content')

<div class="row main-content">

	<div class="col-md-3">
		@include('dashboard.sidebar')
	</div>

	<div class="col-md-9">
		<h1>Edit Profile</h1>
	@include('dashboard.messages')

		<div class="panel">
			<div class="panel-body">
			
				<h4>Personal Info (Optional)</h4>
				
				{{Form::model(Auth::user(), array('route' => array('users.update', Auth::user()->id), 'method' => 'put', 'role' => 'form'))}}
				<input type="hidden" name="m" value="edit-profile" />

				<div class="form-group {{ $errors->has('fullname') ? 'has-error' : '' }}">
					{{ Form::label('fullname', 'Full Name', array('class' => 'form-label')) }}
						{{ Form::text('fullname', Auth::user()->fullname, array('placeholder' => 'Full Name...', 'class' => 'form-control')) }}
						{{ $errors->first('fullname', '<span class="help-block">:message</span>') }}
				</div>
				
				<div class="form-group">
					{{Form::label('showfullname', 'Display full name on your profile?')}}
					{{Form::checkbox('showfullname', '1')}}
				</div>

				<div class="form-group">
					{{Form::label('specialty', 'Your Specialty:')}}
							{{Form::select('specialty', array(
								'Armor' => 'Armor',
								'Aircraft' => 'Aircraft',
								'Warships' => 'Warships',
								'Diorama' => 'Diorama',
								'Landscapes' => 'Landscapes',
								'Railroad' => 'Railroad',
								'Automotive' => 'Automotive',
								'Sci-Fi Miniatures' => 'Sci-Fi Miniatures',
								'Wargaming' => 'Wargaming',
								'Toy Modeling' => 'Toy Modeling'
							), Auth::user()->specialty, array('class' => 'form-control'))}}
				</div>

				<div class="form-group">
					{{Form::label('country', 'Country:')}}
						{{Form::select('country', array(
							'Afghanistan' => 'Afghanistan',
							'Albania' => 'Albania',
							'Algeria' => 'Algeria',
							'Angola' => 'Angola',
							'Argentina' => 'Argentina',
							'Aruba' => 'Aruba',
							'Australia' => 'Australia',
							'Austria' => 'Austria',
							'Azerbaijan' => 'Azerbaijan',
							'Bahamas' => 'Bahamas',
							'Bahrain' => 'Bahrain',
							'Bangladesh' => 'Bangladesh',
							'Barbados' => 'Barbados',
							'Belarus' => 'Belarus',
							'Belgium' => 'Belgium',
							'Benin' => 'Benin',
							'Bolivia' => 'Bolivia',
							'Botswana' => 'Botswana',
							'Brazil' => 'Brazil',
							'Bulgaria' => 'Bulgaria',
							'Cambodia' => 'Cambodia',
							'Canada' => 'Canada',
							'Chile' => 'Chile',
							'China' => 'China',
							'Colombia' => 'Colombia',
							'Costa Rica' => 'Costa Rica',
							'Croatia' => 'Croatia',
							'Cuba' => 'Cuba',
							'Cyprus' => 'Cyprus',
							'Czech Republic' => 'Czech Republic',
							'Denmark' => 'Denmark',
							'Dominican Republic' => 'Dominican Republic',
							'Ecuador' => 'Ecuador',
							'Egypt' => 'Egypt',
							'El Salvador' => 'El Salvador',
							'Estonia' => 'Estonia',
							'Fiji' => 'Fiji',
							'Finland' => 'Finland',
							'France' => 'France',
							'Georgia' => 'Georgia',
							'Germany' => 'Germany',
							'Ghana' => 'Ghana',
							'Greece' => 'Greece',
							'Guadeloupe' => 'Guadeloupe',
							'Guatemala' => 'Guatemala',
							'Honduras' => 'Honduras',
							'Hong Kong' => 'Hong Kong',
							'Hungary' => 'Hungary',
							'Iceland' => 'Iceland',
							'India' => 'India',
							'Indonesia' => 'Indonesia',
							'Iraq' => 'Iraq',
							'Ireland' => 'Ireland',
							'Isle Of Man' => 'Isle Of Man',
							'Israel' => 'Israel',
							'Italy' => 'Italy',
							'Jamaica' => 'Jamaica',
							'Japan' => 'Japan',
							'Jordan' => 'Jordan',
							'Kazakhstan' => 'Kazakhstan',
							'Kenya' => 'Kenya',
							'Kuwait' => 'Kuwait',
							'Latvia' => 'Latvia',
							'Lebanon' => 'Lebanon',
							'Liechtenstein' => 'Liechtenstein',
							'Lithuania' => 'Lithuania',
							'Luxembourg' => 'Luxembourg',
							'Malawi' => 'Malawi',
							'Malaysia' => 'Malaysia',
							'Maldives' => 'Maldives',
							'Malta' => 'Malta',
							'Mauritius' => 'Mauritius',
							'Mexico' => 'Mexico',
							'Moldova' => 'Moldova',
							'Monaco' => 'Monaco',
							'Mongolia' => 'Mongolia',
							'Montenegro' => 'Montenegro',
							'Morocco' => 'Morocco',
							'Myanmar' => 'Myanmar',
							'Nepal' => 'Nepal',
							'Netherlands' => 'Netherlands',
							'New Zealand' => 'New Zealand',
							'Nicaragua' => 'Nicaragua',
							'Nigeria' => 'Nigeria',
							'Norway' => 'Norway',
							'Oman' => 'Oman',
							'Pakistan' => 'Pakistan',
							'Panama' => 'Panama',
							'Papua New Guinea' => 'Papua New Guinea',
							'Paraguay' => 'Paraguay',
							'Peru' => 'Peru',
							'Philippines' => 'Philippines',
							'Poland' => 'Poland',
							'Portugal' => 'Portugal',
							'Puerto Rico' => 'Puerto Rico',
							'Qatar' => 'Qatar',
							'Reunion' => 'Reunion',
							'Romania' => 'Romania',
							'Russian Federation' => 'Russian Federation',
							'Saint Lucia' => 'Saint Lucia',
							'Saudi Arabia' => 'Saudi Arabia',
							'Senegal' => 'Senegal',
							'Serbia' => 'Serbia',
							'Singapore' => 'Singapore',
							'Slovakia' => 'Slovakia',
							'Slovenia' => 'Slovenia',
							'South Africa' => 'South Africa',
							'South Korea' => 'South Korea',
							'Spain' => 'Spain',
							'Sri Lanka' => 'Sri Lanka',
							'Sudan' => 'Sudan',
							'Sweden' => 'Sweden',
							'Switzerland' => 'Switzerland',
							'Thailand' => 'Thailand',
							'Togo' => 'Togo',
							'Trinidad And Tobago' => 'Trinidad And Tobago',
							'Tunisia' => 'Tunisia',
							'Turkey' => 'Turkey',
							'Turkmenistan' => 'Turkmenistan',
							'Uganda' => 'Uganda',
							'Ukraine' => 'Ukraine',
							'United Arab Emirates' => 'United Arab Emirates',
							'United Kingdom' => 'United Kingdom',
							'United States' => 'United States',
							'Uruguay' => 'Uruguay',
							'Uzbekistan' => 'Uzbekistan',
							'Venezuela' => 'Venezuela',
							'Vietnam' => 'Vietnam',
							'Yemen' => 'Yemen',
							'Zimbabwe' => 'Zimbabwe',
							), Auth::user()->country, array('class' => 'form-control'))}}
				</div>
				<div class="form-group">
					{{Form::label('show_location', 'Display country/location on your profile?')}}
					{{Form::checkbox('show_location', '1')}}
				</div>

				<h4>Account Links</h4>
				

				<div class="form-group {{ $errors->has('website') ? 'has-error' : '' }}">
					{{ Form::label('website', 'Website URL:', array('class' => 'form-label')) }}
						{{ Form::url('website', Auth::user()->website, array('placeholder' => 'http://www.yoursite.com', 'class' => 'form-control')) }}
						{{ $errors->first('website', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group {{ $errors->has('facebook') ? 'has-error' : '' }}">
					{{ Form::label('facebook', 'Facebook Profile URL', array('class' => 'form-label')) }}
						{{ Form::text('facebook', Input::old(''), array('placeholder' => 'http://www.facebook.com/yourprofile', 'class' => 'form-control')) }}
						{{ $errors->first('facebook', '<span class="help-block">:message</span>') }}
				</div>

				<div class="form-group has-feedback {{ $errors->has('twitter') ? 'has-error' : '' }}">
					{{ Form::label('twitter', 'Twitter Profile URL', array('class' => 'form-label')) }}
						{{ Form::text('twitter', Input::old(''), array('placeholder' => 'http://twitter.com/youraccount', 'class' => 'form-control')) }}
						{{ $errors->first('twitter', '<span class="help-block">:message</span>') }}
				</div>
				
				<div class="form-group">
					{{Form::submit('Save Changes', array('class' => 'btn btn-primary'))}}
				</div>			
				{{Form::close()}}		
			</div>
		</div>
	</div>

</div>

@stop