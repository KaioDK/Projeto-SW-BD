# Sola Roxa — Frontend Prototype

This is a single-page frontend prototype for *Sola Roxa* — a modern, luxurious, and urban sneakers marketplace inspired by Golden Goose.

Built with:
- HTML5
- TailwindCSS (via Play CDN for quick prototyping)
- GSAP for animations
- Vanilla JavaScript for interactions

How to view
1. Open `index.html` in your browser. Double-clicking the file or using "Open File" in your browser works for this static prototype.
2. For a local dev server (recommended for video autoplay stability):

   - Using Python 3 (if installed):

     ```powershell
     python -m http.server 8000
     # then open http://localhost:8000 in your browser
     ```

Notes and features
- Full-screen hero with background video (fallback to image where supported)
- Sticky, slightly transparent navbar with navigation
- Featured horizontal carousel with snap scroll and buttons
- Collections grid, marketplace preview, stories, and footer
- Custom cursor, GSAP entrance animations, and lazy-loaded media

Design
- Neutral/dark base palette with purple accent `#8B5CF6`.
- Modern sans-serif typography (Inter).

Next steps (suggested)
- Replace placeholder images and videos with real brand assets.
- Integrate with a backend, product API, authentication, and cart.
- Add accessibility improvements and keyboard interactions for carousels.

License & credits
This prototype is provided as-is for demonstration purposes.
