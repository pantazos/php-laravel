@extends('layouts.admin')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h1 class="m-0">{{trans('global.dashboard')}}</h1>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>${{$earnings['count']}}</h3>

                            <p>{{ $earnings['title']  }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{$bookings['count']}}</h3>

                            <p>{{ $bookings['title']  }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{$providers['count']}}</h3>

                            <p>{{ $providers['title']  }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>{{$customers['count']}}</h3>

                            <p>{{ $customers['title']  }}</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <!-- region reviews -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header no-border">
                            <h3 class="card-title">{{trans('cruds.review.title')}}</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-tool btn-sm"><i
                                        class="fas fa-bars"></i> </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                <tr>
                                    <th>{{trans('cruds.review.fields.rating')}}</th>
                                    <th>{{trans('cruds.review.fields.content')}}</th>
                                    <th>{{trans('cruds.review.fields.customer')}}</th>
                                    <th>{{trans('cruds.review.fields.created_at')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestReviews as $key => $review)
                                    <tr>
                                        <td>{{$review->rating}}</td>
                                        <td>{{$review->content}}</td>
                                        <td>{{$review->customer->name}}</td>
                                        <td>{{$review->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- endregion reviews -->

                <!-- region providers -->
                <div class="col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header no-border">
                            <h3 class="card-title">{{trans('panel.providers_card_title')}}</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-tool btn-sm"><i
                                        class="fas fa-bars"></i> </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped table-valign-middle">
                                <thead>
                                <tr>
                                    <th>{{trans('cruds.user.fields.name')}}</th>
                                    <th>{{trans('cruds.user.fields.email')}}</th>
                                    <th>{{trans('cruds.user.fields.phone_number')}}</th>
                                    <th>{{trans('cruds.user.fields.categories')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($latestProviders as $key => $provider)
                                    <tr>
                                        <td>{{$provider->name}}</td>
                                        <td>{{$provider->email}}</td>
                                        <td>{{$provider->phone_number}}</td>
                                        <td>{{$provider->categories->map(function ($category) { return $category->name;})->implode(',')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- endregion providers -->
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    @parent

@endsection
