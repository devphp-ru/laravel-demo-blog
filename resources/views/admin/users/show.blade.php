@extends('admin.layouts.default')

@section('title', $title)

@section('breadcrumbs')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img src="{{ asset('dev_images/avatar5.png') }}" class="profile-user-img img-fluid img-circle" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">Программист</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Статей</b> <a class="float-right">{{ $user->articles->count() }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Комментариев</b> <a class="float-right">{{ $user->articleComments->count() }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Обо мне</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i> Образование</strong>
                    <p class="text-muted">
                        Степень бакалавра наук в области компьютерных наук
                    </p>
                    <hr>
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
                    <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                    </p>
                </div>
            </div>

        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#main" data-toggle="tab">Основное</a></li>
                        <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Активность</a></li>
                        <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Хронология</a></li>
                        <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Настройки</a></li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">

                        <div class="active tab-pane" id="main">

                            <div class="post">
                                <h4>Статьи</h4>
                                @foreach ($user->articles as $article)

                                    <p>
                                        {{ $article->title }} <br>
                                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Читать</a>
                                        <a href="#" class="link-black text-sm">
                                            <i class="far fa-comments mr-1"></i> Комментарии ({{ $article->comments->count() }})
                                        </a>
                                    </p>
                                @endforeach
                            </div>

                            <div class="post clearfix">
                                <h4>Комментарии</h4>
                                @foreach ($user->articleComments as $comment)
                                    <p>
                                        {{ $comment->comment }} <br>
                                        {{ $comment->created_at->format('D d M Y H:i:s') }}
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <div class=" tab-pane" id="activity">

                            <div class="post">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="#" alt="user image">
                                    <span class="username">
                                                    <a href="#">Jonathan Burke Jr.</a>
                                                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                                    </span>
                                    <span class="description">Shared publicly - 7:30 PM today</span>
                                </div>
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                </p>

                                <p>
                                    <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                                    <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                                    <span class="float-right">
                                            <a href="#" class="link-black text-sm">
                                            <i class="far fa-comments mr-1"></i> Comments (5)
                                            </a>
                                            </span>
                                </p>

                                <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                            </div>

                            <div class="post clearfix">
                                <div class="user-block">
                                    <img class="img-circle img-bordered-sm" src="#" alt="User Image">
                                    <span class="username">
                                        <a href="#">Sarah Ross</a>
                                        <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                        </span>
                                    <span class="description">Sent you a message - 3 days ago</span>
                                </div>
                                <p>
                                    Lorem ipsum represents a long-held tradition for designers,
                                    typographers and the like. Some people hate it and argue for
                                    its demise, but others ignore the hate as they create awesome
                                    tools to help create filler text for everyone from bacon lovers
                                    to Charlie Sheen fans.
                                </p>

                                <form class="form-horizontal">
                                    <div class="input-group input-group-sm mb-0">
                                        <input class="form-control form-control-sm" placeholder="Response">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-danger">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>

                        <div class="tab-pane" id="timeline">
                            <div class="timeline timeline-inverse">
                                <div class="time-label">
                                    <span class="bg-danger">10 Feb. 2014 </span>
                                </div>

                                <div>
                                    <i class="fas fa-envelope bg-primary"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 12:05</span>

                                        <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                                        <div class="timeline-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-user bg-info"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                                        <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                                        </h3>
                                    </div>
                                </div>

                                <div>
                                    <i class="fas fa-comments bg-warning"></i>

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                                        <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                                        <div class="timeline-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="timeline-footer">
                                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="tab-pane" id="settings">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputName" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-danger">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
