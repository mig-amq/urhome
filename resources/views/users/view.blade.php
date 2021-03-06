@extends('layouts.app')

@section('header')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js" integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection
@section('content')
    <script>
        var userInfo = '{{$user}}'
        userInfo = JSON.parse(userInfo.replace(/&quot;/g, "\""))
        var myInfo = '{{auth()->user()}}'
        myInfo = JSON.parse(myInfo.replace(/&quot;/g, "\""))

        userInfo.myInfo = myInfo
    </script>
    
    <div class="container-fluid" id="vue-profile-page">
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{$user->ProfileImage}}" class="img-thumbnail rounded-circle" style="height: 200px !important; width: 200px !important;"/>
            </div>
            <div class="col-md">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-weight-bold">{{$user->FirstName}} {{$user->LastName}}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Email Address : </span>
                        <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Contact Number : </span>
                        <a href="tel:{{$user->ContactNo}}">{{$user->ContactNo}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Address : </span>
                    <span class="text-muted">{{$user->LotNo}}, {{$user->Street}}, {{$user->City}}</span>
                    </div>
                </div>
                @if(Auth::check() && Auth::user()->id != $user->id)
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" @click.prevent="converse({{$user->id}})" class="btn btn-sm px-4 mt-2 btn-primary">Say Hi!</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <br/>
        <div class="row">
            @if(Auth::check() && Auth::user()->id === $user->id)
            <div class="col-lg-2 mb-5">
                <div class="row">
                    <div class="col-md-12 list-group">
                        <a href="#" :class="'list-group-item list-group-item-action ' + ((current_segment === 'profile') ? 'active' : '')" @click.prevent="changeSegment('profile')">View Profile</a>
                        <a href="#" :class="'list-group-item list-group-item-action ' + ((current_segment === 'messages') ? 'active' : '')" @click.prevent="changeSegment('messages')">
                            Messages 
                            <span :class="'badge badge-pill ' + ((current_segment === 'messages') ? 'badge-light' : 'badge-primary')">
                                @{{unread_count}}
                            </span>
                        </a>
                        <a href="#" :class="'list-group-item list-group-item-action ' + ((current_segment === 'c_password') ? 'active' : '')" @click.prevent="changeSegment('c_password')">Change Password</a>
                        @if(Auth::check() && Auth::user()->user_type->id != 3)
                        <a href="#" :class="'list-group-item list-group-item-action ' + ((current_segment === 'update') ? 'active' : '')" @click.prevent="changeSegment('update')">Update Account Details</a>
                            <button href="#" class="list-group-item list-group-item-action list-group-item-danger" data-content="Clicking yes will deactivate your account and archive all your listings." data-toggle="confirmation" data-singleton="true" ref="deactivate">Deactivate Account</button>
                        @endif
                    </div>
                </div>
            </div>
            @if (Auth::check() && Auth::user()->id == $user->id)
                <div class="col-lg-10" v-if="current_segment === 'update'">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <h3><b>Update Profile</b></h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12" v-if="success">
                            <div class="alert alert-success" v-html="success">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <input-group ref="confirm_password" type="password" :errors="errors" name="password" :values="values" id="password" label="Password" placeholder="Enter password to confirm updates..." required></input-group>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-8 mb-4">
                            <form @submit.prevent="c_update">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input-group :errors="errors" :values="values.c_profile" name="FirstName" id="firstName" label="First Name" placeholder="John" required></input-group>
                                    </div>
                                    <div class="col-md-6">
                                        <input-group :errors="errors" :values="values.c_profile" name="LastName" id="lastName" label="Last Name" placeholder="Doe" required></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values.c_profile" name="Birthdate" id="birthDate" label="Birth Date" type="date"></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input-group :errors="errors" :values="values.c_profile" name="ContactNo" id="contactNo" label="Mobile Number" placeholder="(+63) 123 456 7890"></input-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Address</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values.c_profile" name="LotNo" id="lotNo" placeholder="Lot #"></input-group>
                                            </div>
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values.c_profile" name="Street" id="street" placeholder="Street"></input-group>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values.c_profile" name="City" type="city" id="city" placeholder="City" required></input-group>
                                            </div>
                                            <div class="col-md-6">
                                                <input-group :errors="errors" :values="values.c_profile" name="Country" :countries="countries" type="country" id="country" placeholder="-- Country --" required></input-group>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 justify-content-right" id="update_profile_btns">
                                        <input type="reset" @click.prevent="reset_profile" value="Reset" class="ml-2 mt-2 btn btn-sm btn-sm-block btn-xs-block btn-secondary float-right">
                                        <button type="submit" class="mt-2 btn btn-sm btn-sm-block btn-xs-block btn-primary float-right">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                            Update Profile Details
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <div class="row" id="update_email_btns">
                                @if ($user->hasVerifiedEmail())
                                    <form class="col-md-12" @submit.prevent="c_email" v-if="!changed_email">
                                        <input-group :errors="errors" :values="values.c_email" name="email" type="email" id="regEmail" label="Change Email" placeholder="{{$user->email}}" required></input-group>
                                        <input type="reset" @click.prevent="reset_email" value="Reset" class="ml-2 mt-2 btn btn-sm btn-sm-block btn-xs-block btn-secondary float-right">
                                        <button type="submit" class="mt-2 btn btn-sm btn-sm-block btn-xs-block btn-primary float-right">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                            Change Email Address
                                        </button>
                                    </form>
                                    <div class="col-md-12" v-else>
                                        <label>Change Email: </label>
                                        <button type="button" @click.prevent="resend_verification" class="btn btn-block btn-success btn-sm">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                            Resend Email Verification Link
                                        </button>
                                    </div>
                                @else
                                    <label>Change Email: </label>
                                    <div class="col-md-12">
                                        <button type="button" @click.prevent="resend_verification" class="btn btn-block btn-success btn-sm">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                            Resend Email Verification Link
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-10" v-if="current_segment === 'c_password'">
                    <div class="row">
                        <form class="col-md-12" @submit.prevent="c_password">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <h3><b>Change Password</b></h3>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12" v-if="success">
                                    <div class="alert alert-success" v-html="success">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <input-group type="password" :errors="errors" name="password" :values="values.c_password" id="password" label="Current Password" placeholder="Enter your current password..." required></input-group>
                                    <input-group type="password" :errors="errors" name="new_password" :values="values.c_password" id="password" label="New Password" placeholder="Enter your new password..." required></input-group>
                                    <input-group type="password" :errors="errors" name="new_password_confirmation" :values="values.c_password" id="password" label="New Password Confirmation" placeholder="Enter your new password again..." required></input-group>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8" id="update_password_btns">
                                    <button type="submit" class="px-4 btn btn-sm btn-sm-block btn-xs-block btn-primary float-right">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-10" v-if="current_segment === 'messages'">
                    {{Auth::user()->messages}}
                    <div class="row">
                        <div class="col-md-3 bg-white rounded w-100 border mb-3" id="chats">
                            <div class="row" v-for="chathead in chatheads">
                                <button :class="'col-md-12 btn border-bottom px-1 d-flex align-items-center ' + ((chathead.id == selected_chat) ? 'btn-primary' : '')" @click.prevent="loadConversation(chathead.id, null)">
                                    <img :src="chathead.User1 == {{Auth::id()}} ? chathead.user2.ProfileImage : chathead.user1.ProfileImage" class="mr-2 rounded-circle bg-white border" style="padding: 3px; max-height: 50px; width: 50px !important   ;">
                                    <b v-if="chathead.User1 == {{Auth::id()}}">@{{chathead.user2.FirstName}} @{{chathead.user2.LastName}}</b>
                                    <b v-else>@{{chathead.user1.FirstName}} @{{chathead.user1.LastName}}</b>
                                </button>
                            </div>
                        </div>
                        <form class="col-md-8" @submit.prevent="send">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="messages" ref="messages" class="bg-white rounded w-100 mb-3 border">
                                        <div class="row no-gutters" v-for="message in messages">
                                            <div class="col-lg-6">
                                                <div class="row p-2 mx-2" v-if="message.user_id != {{Auth::id()}}">
                                                    <div class="col-lg-12 border bg-light rounded">
                                                        <small class="font-weight-bold">@{{message.user.FirstName}} @{{message.user.LastName}}</small>
                                                        <p class="pb-2">@{{message.content}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row p-2 mx-2" v-if="message.user_id == {{Auth::id()}}">
                                                    <div class="col mw-25 pull-right text-md-left border bg-primary rounded" style="color: white">
                                                        <small class="font-weight-bold">@{{message.user.FirstName}} @{{message.user.LastName}}</small>
                                                        <div class="pb-2">@{{message.content}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12" id="text">
                                    <textarea name="message" id="message" rows="5" placeholder="Talk to each other through here" v-model="message" resize="false" class="form-control"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @endif
            @if ($user->user_type->id)
                <div class="{{Auth::check() && Auth::user()->id == $user->id ? "col-lg-10" : "col-md-12"}}">
                    @if(Auth::check() && Auth::user()->id == $user->id)
                        <div id="properties_cards" class="mt-2" v-if="current_segment === 'profile'">
                            <div class="small text-muted mb-2 ml-3">Properties Owned: <b>@{{resultCount}} properties</b></div>
                            <Properties :cards="cards"></Properties>
                            <div class="text-center">
                                <div :class="'spinner-border text-muted ' + ((!loading) ? 'd-none' : '')"></div>
                            </div>
                        </div>
                    @else
                        <div id="properties_cards" class="mt-2">
                            <div class="small text-muted mb-2 ml-3">Properties Owned: <b>@{{resultCount}} properties</b></div>
                            <Properties :cards="cards"></Properties>
                            <div class="text-center">
                                <div :class="'spinner-border text-muted ' + ((!loading) ? 'd-none' : '')"></div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection