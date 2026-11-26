{{-- Large project card on the home page ($project) --}}
<a href="{{ route('projects.show', $project) }}" class="featured-card">
    <figure class="featured-image">
        @if ($project->cover)
            <img src="{{ asset($project->cover) }}" alt="{{ $project->cover_alt }}">
        @endif
    </figure>

    <div class="featured-content">
        <div class="meta">
            <span class="tag">
                <span class="dot" aria-hidden="true"></span>
                <span class="mono-label">{{ $project->title }}</span>
            </span>
            <span class="date">{{ $project->tools }}</span>
        </div>

        <div class="featured-body">
            <h3 class="featured-title">{{ $project->headline_dim }} {{ $project->headline_rest }}</h3>
            <p class="excerpt">{{ $project->description }}</p>
        </div>

        <div class="foot">
            <span class="read-label">View project</span>
            <span class="chip" aria-hidden="true">→</span>
        </div>
    </div>
</a>
