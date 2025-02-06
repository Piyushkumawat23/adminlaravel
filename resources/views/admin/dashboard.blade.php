@extends('admin.layouts.app')

@section('content')
    <div class="dash-content">
        <div class="overview">
            <div class="title">
                <i class="uil uil-tachometer-fast-alt"></i>
                <span class="text">Dashboard</span>
            </div>

            <div class="boxes">
               
                <div class="box box1">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="text">Total Likes</span>
                    <span class="number">50,120</span>
                </div>
                <div class="box box2">
                    <i class="uil uil-comments"></i>
                    <span class="text">Comments</span>
                    <span class="number">20,120</span>
                </div>
                <div class="box box3">
                    <i class="uil uil-share"></i>
                    <span class="text">Total Share</span>
                    <span class="number">10,120</span>
                </div>
            </div>
        </div>

        <div class="activity">
            <div class="title">
                <i class="uil uil-clock-three"></i>
                <span class="text">Recent Activity</span>
            </div>

            <div class="activity-data">
                <div class="data sr-number">
                    <span class="data-title">Sr. No.</span>
                    @foreach ($users as $index => $user)
                        <span class="data-list">{{ $index + 1 }}</span>
                    @endforeach
                </div>

                <div class="data names">
                    <span class="data-title">Name</span>
                    @foreach ($users as $user)
                        <span class="data-list">{{ $user->name }}</span>
                    @endforeach
                </div>
             
                <div class="data email">
                    <span class="data-title">Email</span>
                    @foreach ($users as $user)
                        <span class="data-list">{{ $user->email }}</span>
                    @endforeach
                </div>
               
                <div class="data email">
                    <span class="data-title">Joined</span>
                    @foreach ($users as $user)
                        <span class="data-list">{{ $user->created_at }}</span>
                    @endforeach
                </div>
                

                <div class="data email">
                    <span class="data-title">Status</span>
                    @foreach ($users as $user)
                        <span class="data-list">active</span>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
@endsection
