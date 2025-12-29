<div class="animated-break-container curve-theme">
    {{-- 
        The SVG creates a smooth, animated S-curve. 
        viewBox controls the coordinates (0 to 1440 wide, 0 to 100 high).
        preserveAspectRatio="none" ensures it stretches across the full width.
    --}}
    <svg class="curve-divider" viewBox="0 0 1440 100" preserveAspectRatio="none">
        {{-- 
            The path defines the curve shape. 
            M: Move to (start point)
            C: Cubic Bezier Curve (creates the curve)
            L: Line to (finishes the shape)
        --}}
        <path class="curve-path" d="M0,50 C360,10 720,90 1440,50 L1440,100 L0,100 Z"></path>
    </svg>
</div>

<style>
/* 1. Base Styles and Container */
.animated-break-container.curve-theme {
    position: relative;
    width: 100%;
    /* Height controls the depth of the curve */
    height: 80px; 
    margin: 0; /* Remove vertical space as the curve itself provides the separation */
    overflow: hidden; 
}

/* 2. SVG and Path Styling */
.curve-divider {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.curve-path {
    /* Set this fill color to match the background color of the SECTION *AFTER* the divider */
    fill: #f8f9fa; /* Example: A light background for the next section */
    stroke: none;
    /* CSS transition for smooth movement, if needed */
    transition: fill 0.5s; 
}

/* 3. Active Class (Applied by JavaScript) */
/* When active, the path is animated using the SVG <animate> tag injected by JS */

/* 4. Optional: If you want a subtle glow or shadow on the curve */
.is-active.curve-theme .curve-path {
    filter: drop-shadow(0 -5px 5px rgba(0, 0, 0, 0.1));
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const curveContainers = document.querySelectorAll('.animated-break-container.curve-theme');

    curveContainers.forEach(container => {
        const path = container.querySelector('.curve-path');
        
        // 1. Define the core SVG animation logic
        const animateElement = document.createElementNS("http://www.w3.org/2000/svg", "animate");
        
        // Defines the smooth, subtle movement of the curve's shape
        animateElement.setAttribute('attributeName', 'd');
        animateElement.setAttribute('values', 
            // Shape 1 (Top position)
            'M0,50 C360,10 720,90 1440,50 L1440,100 L0,100 Z; ' + 
            // Shape 2 (Bottom position)
            'M0,50 C360,90 720,10 1440,50 L1440,100 L0,100 Z; ' +  
            // Return to Shape 1
            'M0,50 C360,10 720,90 1440,50 L1440,100 L0,100 Z'     
        );
        animateElement.setAttribute('dur', '8s'); // Slow, continuous wave
        animateElement.setAttribute('repeatCount', 'indefinite');
        
        // 2. Setup the Intersection Observer (The "Smart" part)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Start animation by appending the animate element
                    path.appendChild(animateElement);
                    container.classList.add('is-active');
                } else {
                    // Stop animation by removing the animate element (saves CPU!)
                    if (path.contains(animateElement)) {
                        path.removeChild(animateElement);
                    }
                    container.classList.remove('is-active');
                }
            });
        }, {
            rootMargin: '0px',
            threshold: 0.01 
        });

        // Observe the container
        observer.observe(container);
    });
});
</script>

