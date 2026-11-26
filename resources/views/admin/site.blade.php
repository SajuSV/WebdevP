@extends('layouts.admin')

@section('title', 'Site & Hero')

@section('content')
    <div class="page-head">
        <div>
            <h1 class="page-title">Site, Hero &amp; Statements</h1>
            <p class="page-subtitle">Profile, hero text, scroll statements, contact cards and footer.</p>
        </div>
    </div>

    {{-- Top full-width card: User-Side Access Protection --}}
    <form method="POST" action="{{ route('admin.user-access.update') }}" novalidate>
        @csrf
        @method('PUT')
        <section class="section-card section-card--lime">
            <div class="section-head">
                <h2 class="section-title">User-Side Access Protection</h2>
            </div>
            <div class="grid-3">
                <div class="field">
                    <label class="mono-label field-label">User ID / Email</label>
                    <input type="text" class="input @error('user_access_id') is-invalid @enderror" name="user_access_id"
                           value="{{ old('user_access_id', $visitor?->email) }}" maxlength="255"
                           placeholder="e.g. visitor or guest@example.com">
                    @include('partials.field-error', ['name' => 'user_access_id'])
                </div>
                <div class="field">
                    <div class="field-top">
                        <label for="user_access_password" class="mono-label field-label">User Password</label>
                        <button type="button" class="toggle-btn" data-toggle-password="user_access_password">Show</button>
                    </div>
                    <input id="user_access_password" type="password" class="input @error('user_access_password') is-invalid @enderror" name="user_access_password"
                           value="{{ old('user_access_password', $settings->user_access_password) }}" maxlength="255"
                           placeholder="{{ $visitor ? 'Leave blank to keep current password' : 'Enter password (min 4 chars)' }}">
                    @if ($visitor && ! $settings->user_access_password)
                        <span class="field-hint">Leave blank to keep the existing user password.</span>
                    @endif
                    @include('partials.field-error', ['name' => 'user_access_password'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Require Login</label>
                    <label class="checkbox-box">
                        <span>Enable access protection</span>
                        <input type="checkbox" class="checkbox-switch" name="require_user_login" value="1"
                               @checked(old('require_user_login', $settings->require_user_login))>
                    </label>
                    @include('partials.field-error', ['name' => 'require_user_login'])
                </div>
            </div>
        </section>
        @include('partials.save-bar', ['label' => 'Save Access Settings'])
    </form>

    {{-- Main site settings form --}}
    {{-- enctype is required for file uploads. @method('PUT') tells Laravel this is an update --}}
    <form method="POST" action="{{ route('admin.site.update') }}" enctype="multipart/form-data" class="section-full" novalidate>
        @csrf
        @method('PUT')

        <div class="sections-grid">
            {{-- Left column --}}
            <div class="col-stack">
                <section class="section-card">
                    <div class="section-head"><h2 class="section-title">Profile &amp; Media</h2></div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="mono-label field-label">Name<span class="req-star" aria-hidden="true">*</span></label>
                            <input type="text" class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name', $settings->name) }}" maxlength="60" required>
                            @include('partials.field-error', ['name' => 'name'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">Role</label>
                            <input type="text" class="input @error('role') is-invalid @enderror" name="role" value="{{ old('role', $settings->role) }}" maxlength="60">
                            @include('partials.field-error', ['name' => 'role'])
                        </div>
                        <div class="field field-full">
                            <label class="mono-label field-label">Tagline</label>
                            <input type="text" class="input @error('tagline') is-invalid @enderror" name="tagline" value="{{ old('tagline', $settings->tagline) }}" maxlength="120">
                            @include('partials.field-error', ['name' => 'tagline'])
                        </div>
                        @include('partials.image-field', [
                            'label' => 'Avatar Image',
                            'name' => 'avatar',
                            'fileName' => 'avatar_file',
                            'value' => old('avatar', $settings->avatar),
                        ])
                        <div class="field field-full">
                            <label class="mono-label field-label">Resume PDF URL</label>
                            <input type="url" class="input @error('resume_url') is-invalid @enderror" name="resume_url" value="{{ old('resume_url', $settings->resume_url) }}" maxlength="300">
                            @include('partials.field-error', ['name' => 'resume_url'])
                        </div>
                        <div class="field field-full">
                            <label class="mono-label field-label">Hero / Footer Video URL</label>
                            <input type="url" class="input @error('hero_video_url') is-invalid @enderror" name="hero_video_url" value="{{ old('hero_video_url', $settings->hero_video_url) }}" maxlength="300">
                            @include('partials.field-error', ['name' => 'hero_video_url'])
                        </div>
                    </div>
                </section>

                <section class="section-card">
                    <div class="section-head"><h2 class="section-title">Section Headings</h2></div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="mono-label field-label">Services Heading</label>
                            <input type="text" class="input @error('services_heading') is-invalid @enderror" name="services_heading" value="{{ old('services_heading', $settings->services_heading) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'services_heading'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">About Heading</label>
                            <input type="text" class="input @error('about_title') is-invalid @enderror" name="about_title" value="{{ old('about_title', $settings->about_title) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'about_title'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">Portfolio Heading</label>
                            <input type="text" class="input @error('work_in_focus_title') is-invalid @enderror" name="work_in_focus_title" value="{{ old('work_in_focus_title', $settings->work_in_focus_title) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'work_in_focus_title'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">Contact Heading</label>
                            <input type="text" class="input @error('contact_heading') is-invalid @enderror" name="contact_heading" value="{{ old('contact_heading', $settings->contact_heading) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'contact_heading'])
                        </div>
                    </div>
                </section>

                <section class="section-card">
                    <div class="section-head">
                        <h2 class="section-title">Projects Sub-Page (/projects)</h2>
                    </div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="mono-label field-label">Projects Page Title</label>
                            <input type="text" class="input @error('projects_page_title') is-invalid @enderror" name="projects_page_title" value="{{ old('projects_page_title', $settings->projects_page_title) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'projects_page_title'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">Projects Page Muted Title</label>
                            <input type="text" class="input @error('projects_page_muted_title') is-invalid @enderror" name="projects_page_muted_title" value="{{ old('projects_page_muted_title', $settings->projects_page_muted_title) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'projects_page_muted_title'])
                        </div>
                        <div class="field field-full">
                            <label class="mono-label field-label">Projects Page Description</label>
                            <textarea class="textarea @error('projects_page_description') is-invalid @enderror" name="projects_page_description" maxlength="300">{{ old('projects_page_description', $settings->projects_page_description) }}</textarea>
                            @include('partials.field-error', ['name' => 'projects_page_description'])
                        </div>
                    </div>
                </section>
            </div>

            {{-- Right column --}}
            <div class="col-stack">
                <section class="section-card">
                    <div class="section-head"><h2 class="section-title">Hero Section</h2></div>
                    <div class="grid-2">
                        <div class="field">
                            <label class="mono-label field-label">Title Line 1</label>
                            <input type="text" class="input @error('hero_title_line1') is-invalid @enderror" name="hero_title_line1" value="{{ old('hero_title_line1', $settings->hero_title_line1) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'hero_title_line1'])
                        </div>
                        <div class="field">
                            <label class="mono-label field-label">Title Line 2</label>
                            <input type="text" class="input @error('hero_title_line2') is-invalid @enderror" name="hero_title_line2" value="{{ old('hero_title_line2', $settings->hero_title_line2) }}" maxlength="50">
                            @include('partials.field-error', ['name' => 'hero_title_line2'])
                        </div>
                        <div class="field field-full">
                            <label class="mono-label field-label">Subtitle</label>
                            <textarea class="textarea @error('hero_subtitle') is-invalid @enderror" name="hero_subtitle" maxlength="200">{{ old('hero_subtitle', $settings->hero_subtitle) }}</textarea>
                            @include('partials.field-error', ['name' => 'hero_subtitle'])
                        </div>
                        <div class="field field-full">
                            <label class="mono-label field-label">Button Label</label>
                            <input type="text" class="input @error('hero_cta_label') is-invalid @enderror" name="hero_cta_label" value="{{ old('hero_cta_label', $settings->hero_cta_label) }}" maxlength="30">
                            @include('partials.field-error', ['name' => 'hero_cta_label'])
                        </div>
                    </div>
                </section>

                <section class="section-card" data-repeater>
                    <div class="section-head">
                        <h2 class="section-title">Scroll Statements</h2>
                        <button type="button" class="btn-outline" data-add>+ Add Statement</button>
                    </div>

                    <div class="form-stack" data-rows>
                        @foreach (old('statements', $statements) as $i => $row)
                            @include('admin.rows.statement', ['i' => $i, 'row' => $row])
                        @endforeach
                    </div>

                    {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
                    <template>
                        @include('admin.rows.statement', ['i' => '__INDEX__', 'row' => []])
                    </template>
                </section>
            </div>
        </div>

        <section class="section-card section-full" data-repeater>
            <div class="section-head">
                <h2 class="section-title">Contact Cards</h2>
                <button type="button" class="btn-outline" data-add>+ Add Contact Card</button>
            </div>

            <div class="grid-2" data-rows>
                @foreach (old('contacts', $contacts) as $i => $row)
                    @include('admin.rows.contact', ['i' => $i, 'row' => $row])
                @endforeach
            </div>

            {{-- JavaScript copies this blank row and replaces __INDEX__ with a new number --}}
            <template>
                @include('admin.rows.contact', ['i' => '__INDEX__', 'row' => []])
            </template>
        </section>

        <section class="section-card section-full">
            <div class="section-head"><h2 class="section-title">Footer &amp; Contact Details</h2></div>
            <div class="grid-3">
                <div class="field">
                    <label class="mono-label field-label">Email<span class="req-star" aria-hidden="true">*</span></label>
                    <input type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email', $settings->email) }}" maxlength="100" required>
                    @include('partials.field-error', ['name' => 'email'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Location</label>
                    <input type="text" class="input @error('location') is-invalid @enderror" name="location" value="{{ old('location', $settings->location) }}" maxlength="80">
                    @include('partials.field-error', ['name' => 'location'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Phone Display</label>
                    <input type="text" class="input @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $settings->phone) }}" maxlength="30">
                    @include('partials.field-error', ['name' => 'phone'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Phone Link</label>
                    <input type="text" class="input @error('phone_href') is-invalid @enderror" name="phone_href" value="{{ old('phone_href', $settings->phone_href) }}" maxlength="30">
                    <span class="field-hint">Starts with tel:</span>
                    @include('partials.field-error', ['name' => 'phone_href'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">LinkedIn URL</label>
                    <input type="url" class="input @error('linkedin_url') is-invalid @enderror" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}" maxlength="300">
                    @include('partials.field-error', ['name' => 'linkedin_url'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">LinkedIn Label</label>
                    <input type="text" class="input @error('linkedin_label') is-invalid @enderror" name="linkedin_label" value="{{ old('linkedin_label', $settings->linkedin_label) }}" maxlength="80">
                    @include('partials.field-error', ['name' => 'linkedin_label'])
                </div>
                <div class="field field-full">
                    <label class="mono-label field-label">Footer Heading</label>
                    <textarea class="textarea @error('footer_heading') is-invalid @enderror" name="footer_heading" maxlength="150">{{ old('footer_heading', $settings->footer_heading) }}</textarea>
                    @include('partials.field-error', ['name' => 'footer_heading'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Footer Button Label</label>
                    <input type="text" class="input @error('footer_cta_label') is-invalid @enderror" name="footer_cta_label" value="{{ old('footer_cta_label', $settings->footer_cta_label) }}" maxlength="30">
                    @include('partials.field-error', ['name' => 'footer_cta_label'])
                </div>
                <div class="field">
                    <label class="mono-label field-label">Footer Disclaimer</label>
                    <input type="text" class="input @error('footer_disclaimer') is-invalid @enderror" name="footer_disclaimer" value="{{ old('footer_disclaimer', $settings->footer_disclaimer) }}" maxlength="80">
                    @include('partials.field-error', ['name' => 'footer_disclaimer'])
                </div>
                <div class="field field-full">
                    <label class="mono-label field-label">Copyright</label>
                    <input type="text" class="input @error('copyright') is-invalid @enderror" name="copyright" value="{{ old('copyright', $settings->copyright) }}" maxlength="80">
                    @include('partials.field-error', ['name' => 'copyright'])
                </div>
            </div>
        </section>

        @include('partials.save-bar', ['label' => 'Save Site Settings'])
    </form>
@endsection
