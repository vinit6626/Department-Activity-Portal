@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Firstname Middlename Surname" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="contact_no" class="col-md-4 col-form-label text-md-right">Contact Number</label>

                            <div class="col-md-6">
                                <input id="contact_no" type="number" class="form-control{{ $errors->has('contact_no') ? ' is-invalid' : '' }}" name="contact_no" value="{{ old('contact_no') }}" required autofocus>
                                @if ($errors->has('contact_no'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('contact_no') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="department" class="col-md-4 col-form-label text-md-right">Department</label>

                            <div class="col-md-6">
                                <select id="department" name="department" class="form-control{{ $errors->has('department') ? ' is-invalid' : '' }}" required autofocus>
                                    <option value="">----Select----</option>
                                    <option value="Information Technology" 
                                    <?php if(old('department')=='Information Technology'){echo "selected";}
                                    ?>
                                    >Information Technology</option>
                                    <option value="Computer Engineering"
                                    <?php if(old('department')=='Computer Engineering'){echo "selected";}
                                    ?>
                                    >Computer Engineering</option>
                                    <option value="Mechanical Engineering"
                                    <?php if(old('department')=='Mechanical Engineering'){echo "selected";}
                                    ?>
                                    >Mechanical Engineering</option>                    
                                    <option value="Civil Engineering"
                                    <?php if(old('department')=='Civil Engineering'){echo "selected";}
                                    ?>
                                    >Civil Engineering</option>
                                    <option value="Electronics Engineering"
                                    <?php if(old('department')=='Electronics Engineering'){echo "selected";}
                                    ?>
                                    >Electronics Engineering</option>
                                    <option value="Electronics & Communication"
                                    <?php if(old('department')=='Electronics & Communication'){echo "selected";}
                                    ?>
                                    >Electronics & Communication</option>
                                    <option value="Electrical Engineering"
                                    <?php if(old('department')=='Electrical Engineering'){echo "selected";}
                                    ?>
                                    >Electrical Engineering</option>
                                    <option value="Production Engineering"
                                    <?php if(old('department')=='Production Engineering'){echo "selected";}
                                    ?>
                                    >Production Engineering</option>
                                    <option value="Structural Engineering"
                                    <?php if(old('department')=='Structural Engineering'){echo "selected";}
                                    ?>
                                    >Structural Engineering</option>
                                    <option value="Mathematics"
                                    <?php if(old('department')=='Mathematics'){echo "selected";}
                                    ?>
                                    >Mathematics</option>
                                </select>


                                @if ($errors->has('department'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Minimum 6 chracters" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right" >{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
