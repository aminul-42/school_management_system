@extends('backend.student.layouts.app')

@section('title', $course->title . ' | All Lectures')

@push('styles')

<style>
/* --- New CSS for layout and gap --- */
.course-show-container {
    display: flex;
    gap: 30px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 15px;
}

.main-content { flex: 3; min-width: 0; }

.video-wrapper {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    margin-bottom: 20px;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    background-color: #000;
}

.video-wrapper iframe {
    position: absolute; top:0; left:0;
    width:100%; height:100%; border:none;
}

/* Updated Overlay for Default Message */
.video-message-overlay {
    position: absolute;
    top: 0; left: 0; width: 100%; height: 100%;
    display: flex; flex-direction: column; justify-content: center; align-items: center;
    background-color: rgba(0,0,0,0.85);
    color: white; text-align: center; padding: 20px;
    font-size: 1.2rem; z-index: 10;
    transition: opacity 0.3s;
    opacity: 0; 
    pointer-events: none; /* Initially non-clickable */
}

.video-message-overlay.show { 
    opacity: 1; 
    pointer-events: auto; 
}
.video-message-overlay i {
    font-size: 3rem; /* Larger icon */
    margin-bottom: 15px;
}

.playlist-sidebar {
    flex: 1;
    min-width: 300px;
    max-width: 350px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    height: fit-content;
    position: sticky;
    top: 20px;
}

.playlist-header {
    /* Base styles for header */
    padding: 15px 20px;
    font-weight: 600;
    font-size: 1.1rem;
}

/* Minimum Gap between playlists */
.playlist-sidebar > .playlist-header:nth-of-type(2) {
    margin-top: 20px; 
}

.lecture-list-ul { list-style: none; padding: 0; margin: 0; max-height: 80vh; overflow-y: auto; }
.lecture-item { display: flex; align-items: center; padding: 15px 20px; border-bottom: 1px solid #f5f5f5; cursor: pointer; transition: background-color 0.2s; font-size: 0.95rem; }
.lecture-item:hover { background-color: #f8f9fa; }
.lecture-item.active { background-color: #fff3cd; border-left: 4px solid #ffc107; font-weight: 600; }
.lecture-serial { font-weight: 700; width: 30px; text-align: center; color: #1f3d7a; }
.lecture-item.active .lecture-serial { color: #101c37; }

@media (max-width: 1024px) {
    .course-show-container { flex-direction: column; gap: 20px; padding: 0 10px; }
    .main-content, .playlist-sidebar { flex: none; width: 100%; max-width: 100%; }
    .playlist-sidebar { position: static; order: 2; }
    .main-content { order: 1; }
    .lecture-list-ul { max-height: 50vh; }
}
</style>
@endpush

@section('content')
<div class="mb-4">
    <button 
        type="button" 
        onclick="window.location='{{ route('student.courses') }}'" 
        class="btn-primary">
        <i class="fa fa-arrow-left mr-2"></i> Back to My Courses
    </button>
</div>



<div class="course-show-container">
    {{-- LEFT: Video Player --}}
    <div class="main-content">
        <div class="video-wrapper">
            <iframe id="videoPlayer" src="" title="Course Lecture Player"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            {{-- DEFAULT MESSAGE OVERLAY: Starts visible ('show') --}}
            <div id="videoMessageOverlay" class="video-message-overlay show">
                <i class="fa fa-hand-pointer-o"></i>
                <h3 class="font-bold mt-2">No Lecture Selected</h3>
                <p id="videoMessageText" class="mt-2">
                    Please select a lecture from the playlist to begin your learning journey.
                </p>
            </div>
        </div>

        {{-- Set default title --}}
        <h2 class="current-lecture-title" id="currentLectureTitle">Please select a lecture from playlist</h2>


        <div class="course-description">
            <p>{{ $course->description ?? 'Dive deep into the course material.' }}</p>
        </div>
    </div>

    {{-- RIGHT: Playlist Sidebar --}}
    <div class="playlist-sidebar">
        <div class="playlist-header" style="background:#1f3d7a; color:#fff; border-top-left-radius:12px;border-top-right-radius:12px;">
            🎬 Pre-recorded Lessons ({{ $prerecordedLectures->count() }})
        </div>
        <ul class="lecture-list-ul mb-4">
            @foreach ($prerecordedLectures as $lecture)
                <li class="lecture-item {{ $currentLecture && $currentLecture->id === $lecture->id ? 'active' : '' }}"
                    data-lecture-id="{{ $lecture->id }}" 
                    data-video-url="{{ $lecture->youtube_link ?? '' }}"
                    data-type="pre_recorded"
                    data-title="{{ $lecture->title }}"
                    onclick="loadLecture(this)">
                    <span class="lecture-serial">{{ $loop->iteration }}</span>
                    <span class="lecture-title ml-3 truncate">{{ $lecture->title }}</span>
                </li>
            @endforeach
        </ul>

        {{-- The gap is handled by the CSS rule: .playlist-sidebar > .playlist-header:nth-of-type(2) { margin-top: 20px; } --}}
        <div class="playlist-header" style="background:#dc3545; color:#fff; border-top-left-radius:12px;border-top-right-radius:12px;">
            🔴 Live Sessions ({{ $liveLectures->count() }})
        </div>
        <ul class="lecture-list-ul">
            @foreach ($liveLectures as $lecture)
                <li class="lecture-item {{ $currentLecture && $currentLecture->id === $lecture->id ? 'active' : '' }}"
                    data-lecture-id="{{ $lecture->id }}"
                    data-video-url="{{ $lecture->youtube_link ?? '' }}"
                    data-type="live"
                    data-title="{{ $lecture->title }}"
                    onclick="loadLecture(this)">
                    <span class="lecture-serial">{{ $loop->iteration }}</span>
                    <span class="lecture-title ml-3 truncate">{{ $lecture->title }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Key for storing video progress in Local Storage (simulates database tracking)
    const PROGRESS_KEY = 'course_{{ $course->id }}_lecture_progress';
    
    // ===============================================
    // PROGRESS TRACKING FUNCTIONS (Local Storage Simulation)
    // ===============================================

    /**
     * Gets the last known playback time for a given lecture ID from Local Storage.
     * @param {number} lectureId
     * @returns {number} Time in seconds, or 0.
     */
    function getSavedTime(lectureId) {
        try {
            const progress = JSON.parse(localStorage.getItem(PROGRESS_KEY) || '{}');
            // Returns time in seconds, rounded down.
            return Math.floor(progress[lectureId] || 0); 
        } catch (e) {
            console.error("Error retrieving progress from Local Storage:", e);
            return 0;
        }
    }

    /**
     * Saves a placeholder time to Local Storage upon lecture selection.
     * NOTE: To save the *actual* last stop time, you need the full YouTube Iframe Player API
     * and a listener for the video's 'onStateChange' event, followed by an AJAX call 
     * to a Laravel API endpoint upon page close (window.onbeforeunload).
     */
    function saveCurrentProgress(lectureId, timeInSeconds) {
        if (!lectureId) return;
        
        // This is a simulation. In production, you would update the database via AJAX.
        // For demonstration, we save a mock time.
        try {
            const progress = JSON.parse(localStorage.getItem(PROGRESS_KEY) || '{}');
            progress[lectureId] = timeInSeconds;
            localStorage.setItem(PROGRESS_KEY, JSON.stringify(progress));
        } catch (e) {
            console.error("Error saving progress to Local Storage:", e);
        }
    }
    
    // ===============================================
    // LECTURE LOADING LOGIC
    // ===============================================

    const lectureItems = document.querySelectorAll('.lecture-item');
    const videoPlayer = document.getElementById('videoPlayer');
    const currentLectureTitle = document.getElementById('currentLectureTitle');
    const messageOverlay = document.getElementById('videoMessageOverlay');
    const defaultTitle = currentLectureTitle.textContent; // Store default title

    function getEmbedUrl(url) {
        if (!url) return '';
        // Convert watch?v= or youtu.be/ to embed format
        if (url.includes('watch?v=')) return url.replace('watch?v=', 'embed/');
        if (url.includes('youtu.be/')) return url.replace('youtu.be/', 'youtube.com/embed/');
        
        return url;
    }

    /**
     * Loads the selected lecture video.
     */
    window.loadLecture = function(element) {
        const lectureId = element.dataset.lectureId;
        let videoUrl = element.dataset.videoUrl;
        const type = element.dataset.type;
        const title = element.dataset.title;

        // 1. Update UI and active state
        currentLectureTitle.textContent = title;
        lectureItems.forEach(i => i.classList.remove('active'));
        element.classList.add('active');
        element.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // 2. Clear player
        videoPlayer.src = '';

        // 3. Handle Live/Missing/Pre-recorded logic
        if (type === 'live') {
            videoPlayer.style.opacity = 0;
            document.getElementById('videoMessageText').innerHTML = '<i class="fa fa-calendar-check-o"></i><p class="font-bold mb-2">Live Session Scheduled</p>This lecture is a live stream. Check the live session schedule.';
            messageOverlay.classList.add('show');
        } else if (videoUrl) {
            // Hide message, show video player
            messageOverlay.classList.remove('show');
            
            videoUrl = getEmbedUrl(videoUrl);
            const separator = videoUrl.includes('?') ? '&' : '?';
            
            // --- Resume Playback Logic ---
            const lastTime = getSavedTime(lectureId);
            const startParam = (lastTime > 0) ? `&start=${lastTime}` : '';

            // 4. Load the video (NO autoplay=1)
            // Note: start= parameter automatically resumes playback from the timestamp.
            videoPlayer.src = `${videoUrl}${separator}rel=0&modestbranding=1&controls=1&fs=1${startParam}`;
            
            // 5. Simulate progress update (mark as started)
            saveCurrentProgress(lectureId, lastTime > 0 ? lastTime : 1);

        } else {
            // Video URL missing
            videoPlayer.style.opacity = 0;
            document.getElementById('videoMessageText').innerHTML = '<i class="fa fa-exclamation-triangle"></i><p class="font-bold mb-2">Content Unavailable</p>Video link missing or invalid.';
            messageOverlay.classList.add('show');
        }
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Find the initial active lecture (set by the controller if user returns)
        const activeLecture = document.querySelector('.lecture-item.active');
        
        if (activeLecture) {
            // Load the active lecture to resume from the last stop time
            loadLecture(activeLecture);
        } else {
            // Ensure the default message is shown if no lecture is active
            messageOverlay.classList.add('show');
            currentLectureTitle.textContent = defaultTitle;
        }
    });
</script>
@endpush