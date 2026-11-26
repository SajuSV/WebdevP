@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Projects</h1>
            <p class="page-subtitle">Add, edit or delete projects. Home page tabs update automatically.</p>
        </div>
        <a class="btn-outline" href="{{ route('admin.projects.create') }}">+ Add Project</a>
    </div>

    <section class="section-card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Order</th><th>Cover</th><th>Title</th><th>Slug</th><th>Images</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>{{ $project->sort_order }}</td>
                            <td>
                                @if ($project->cover)
                                    <img class="thumb" src="{{ asset($project->cover) }}" alt="">
                                @endif
                            </td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->slug }}</td>
                            <td>{{ $project->images_count }}</td>
                            <td>
                                <div class="row-actions">
                                    <a class="btn-outline" href="{{ route('admin.projects.edit', $project) }}">Edit</a>
                                    {{-- HTML forms cannot send DELETE, so @method('DELETE') is used --}}
                                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" data-confirm="Delete this project and its gallery?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No projects yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
