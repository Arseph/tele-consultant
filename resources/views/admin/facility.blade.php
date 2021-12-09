@extends('layouts.app')

@section('content')
<style>
    label {
        padding: 0px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .disAble {
        pointer-events:none;
    }
</style>
<div class="container">
    <div class="box box-success">
        <div class="box-header with-border">
        <form id="facility_form" method="POST">
            <div class="pull-right">
                <button title="save" type="submit" class="btnSave btn btn-success hide"><i class="far fa-save"></i></button>
                <h4 id="btnEdit" title="Edit Facility" onclick="enableView()"><a href="#"><i class="far fa-edit"></i></a></h4>
            </div>
            <h1 class="title-info">{{ $facility->facilityname }}</h1>
        </div>
        <div id="formEdit" class="box-body disAble">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="hidden" class="form-control" value="{{ $facility->id }}" name="id" id="facility_id">
                            <label>Facility Name:</label>
                            <input type="text" class="form-control" value="{{ $facility->facilityname }}" name="facilityname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Facility Code:</label>
                            <input type="text" class="form-control" value="{{ $facility->fshortcode }}" name="fshortcode" required>
                        </div>
                    </div>
                    <div id="divOld" class="col-md-4">
                        <div class="form-group">
                            <label>Abbr:</label>
                            <input type="text" class="form-control" value="{{ $facility->oldfacilityname }}" name="oldfacilityname">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Province:</label>
                            <select class="select2" name="prov_psgc" id="province">
                                <option value="{{ $facility->province->prov_psgc }}" selected="">{{ $facility->province->prov_name }}</option>
                                <option>Select Province</option>
                                @foreach($province as $row)
                                   <option value="{{ $row->prov_psgc }}">{{ $row->prov_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Municipality:</label>
                            <select class="select2" name="muni_psgc" id="muni_psgc">
                                <option value="{{ $facility->municipal->muni_psgc }}" selected="">{{ $facility->municipal->muni_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Barangay:</label>
                            <select class="select2" name="brgy_psgc" id="barangay">
                                <option value="{{ $facility->barangay->brg_psgc }}" selected="">{{ $facility->barangay->brg_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div id="divStreet" class="form-group">
                            <label>Address:</label>
                            <input type="text" class="form-control" value="{{ $facility->streetname }}" name="streetname">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact:</label>
                            <input type="text" class="form-control" value="{{ $facility->landlineno }}" name="landlineno" required>
                        </div>
                    </div>
                    <div id="divFax" class="col-md-4">
                        <div class="form-group">
                            <label>Fax Number:</label>
                            <input type="text" class="form-control" value="{{ $facility->faxnumber }}" name="faxnumber">
                        </div>
                    </div>
                    <div id="divEmail" class="col-md-4">
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="text" class="form-control" value="{{$facility->emailaddress}}" name="emailaddress">
                        </div>
                    </div>
                    <div id="divUrl" class="col-md-4">
                        <div class="form-group">
                            <label>Official Website URL:</label>
                            <input type="text" class="form-control" value="{{$facility->officialwebsiteurl}}" name="officialwebsiteurl">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <h4>Facility Head:</h4>
                    <div class="row">
                      <div class="col-md-3">
                        <label>First name:</label>
                        <input type="text" class="form-control" value="{{$facility->facilityhead_fname}}" name="facilityhead_fname" placeholder="First name">
                      </div>
                      <div id="divMi" class="col-md-3">
                        <label>Middle name:</label>
                        <input type="text" class="form-control" value="{{$facility->facilityhead_mi}}" name="facilityhead_mi" placeholder="Middle name">
                      </div>
                      <div class="col-md-3">
                        <label>Last name:</label>
                        <input type="text" class="form-control" value="{{$facility->facilityhead_lname}}" name="facilityhead_lname" placeholder="Last name">
                      </div>
                      <div class="col-md-3">
                        <label>Position:</label>
                        <input type="text" class="form-control" value="{{$facility->facilityhead_position}}" name="facilityhead_position">
                      </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status:</label>
                            <select class="form-control" name="status">
                                <option value="1" @if($facility->status == 1)selected>Active</option>
                                <option value="0" @else selected @endif>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hospital License Status:</label>
                            <input type="text" class="form-control" value="{{$facility->hosp_licensestatus}}" name="hosp_licensestatus">
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group">
                            <label>Service Capability:</label>
                            <input type="text" class="form-control" value="{{$facility->hosp_servcapability}}" name="hosp_servcapability">
                        </div>
                    </div>
                    <div class="col-md-4">
                         <div class="form-group">
                            <label>Bed Capacity:</label>
                            <input type="text" class="form-control" value="{{$facility->hosp_bedcapacity}}" name="hosp_bedcapacity">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Latitude:</label>
                            <input type="text" class="form-control" value="{{$facility->latitude}}" name="latitude">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Longitude:</label>
                            <input type="text" class="form-control" value="{{$facility->longitude}}" name="longitude">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label>Remarks:</label>
                    <textarea class="form-control" rows="2" name="remarks">{{$facility->remarks}}</textarea>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
    @include('admin.scripts.facility')
@endsection
