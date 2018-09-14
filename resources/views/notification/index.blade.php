
@extends('layouts.app')

@section('title') General Announcements @endsection

@section('content')

<!--CONTENT CONTAINER-->
<!--===================================================-->
<div id="content-container">
    <div id="page-head">

        <!--Page Title-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <div id="page-title">
            <h1 class="page-header text-overflow">General Announcements</h1>
        </div>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End page title-->


        <!--Breadcrumb-->
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <ol class="breadcrumb">
            <li>
                <a href="forms-general.html#">
                    <i class="demo-pli-home"></i>
                </a>
            </li>
            <li>
                <a href="{{route('dashboard')}}">Dashboard</a>
            </li>
            <li class="active">Announcements</li>
        </ol>
        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <!--End breadcrumb-->

    </div>


    <!--Page content-->
    <!--===================================================-->
    <div id="page-content">
        <div class="row">


<div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title">announcements</h3>
                                </div>
                       <div class="col-md-9 col-lg-offset-2">
                  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)

                            <div class="alert alert-danger">{{ $error }}</div>

                        @endforeach

                    @endif
                    </div>
                                <!--No Label Form-->
                                <!--===================================================-->
                               <form id="send-announcement-form" role="form"  method="POST" action="{{route('calendar.announcement')}}">
                                         @csrf  <div class="panel-body">
                                        <div class="row">

                                            <div class="col-md-4 mar-btm">
                                                 <label class="col-md-2 control-label"  for="inputEmail">To</label>
                                        <?php if(isset($_GET['mail'])) { ?>
                                                    <input type="email" id="inputEmail" name="to[]" value="<?php echo $_GET['mail']; ?> " class="form-control">
                                        <?php echo '</div>'; }else{ ?>
                                        <select id="num-selector" data-live-search="true" name="to[]" data-width="100%" data-actions-box="true" class="selectpicker" multiple>
                                          @foreach ($contact as $member)
                                            <option value="{{$member->branchcode}}">{{ucwords($member->getName())}}</option>
                                          @endforeach
                                        </select>
                                                </div>

                                  <?php }?>

                                            <div class="col-md-4 mar-btm">
                                                 <label class="col-md-2 control-label" for="inputSubject">By who</label>
                                            <div class="col-md-9">
                                                <input type="text"  id="by_who" class="form-control{{ $errors->has('by_who') ? ' is-invalid' : '' }}" name="by_who" value="{{ old('by_who') }}">
                                                  <br>
                                @if ($errors->has('by_who'))
                                    <span class="alert alert-danger">
                                        <strong>{{ $errors->first('by_who') }}</strong>
                                    </span>
                                @endif
                                            </div>
                                            </div>
                                            <div class="col-md-4 mar-btm">
                                                         <label class="col-md-2 control-label" for="inputSubject">Start Time</label>
                                  <div class="input-group clockpicker col-md-9">
                                <input type="text" class="form-control" value="09:00" name="time">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                                            </div>
                                                <div class="col-md-4 mar-btm">
                                                         <label class="col-md-2 control-label" for="inputSubject">Stop Time</label>
                                  <div class="input-group clockpicker col-md-9">
                                <input type="text" class="form-control" value="09:30" name="stime">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                                            </div>
                                                 <div class="col-md-4 mar-btm">
                                                         <label class="col-md-3 control-label" for="inputSubject">Start Date</label>
                                             <input style="border:1px solid rgba(0,0,0,0.07);height: 33px;
                                  font-size: 13px;
                                  border-radius: 3px;display: block;
                                  width: 100%;
                                   color: #555;
                                  background-color: #fff;outline:none; margin-top:15px;padding:2px 10px" type="text" placeholder="Event Date" name="sdate" class="datepicker"/>

                    <br>
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif

                                        </div>
                                          <div class="col-md-4 mar-btm">
                                                         <label class="col-md-3 control-label" for="inputSubject">Stop Date</label>
                                             <input style="border:1px solid rgba(0,0,0,0.07);height: 33px;
                                  font-size: 13px;
                                  border-radius: 3px;display: block;
                                  width: 100%;
                                   color: #555;
                                  background-color: #fff;outline:none; margin-top:15px;padding:2px 10px" type="text" placeholder="Event Date" name="date" class="datepicker"/>

                    <br>
                                @if ($errors->has('date'))
                                    <span class="alert alert-danger">
                                        <strong>{{ $errors->first('date') }}</strong>
                                    </span>
                                @endif

                                        </div>

                                        <textarea placeholder="Message" name="message" rows="10" class="form-control"></textarea>
                                    </div>
                                    <div class="panel-footer text-right">
                                       <button id="mail-send-btn" type="submit" class="btn btn-primary">
                                                <i class="demo-psi-mail-send icon-lg icon-fw"></i> Create Announcement
                                            </button>
                                    </div>
                                </form>
                                <!--===================================================-->
                                <!--End No Label Form-->

                            </div>




        </div>


    </div>
    <!--===================================================-->
    <!--End page content-->

</div>
<!--===================================================-->
<!--END CONTENT CONTAINER-->

@endsection