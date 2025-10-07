;(($) => {
  // Declare dcgAjax variable
  const dcgAjax = window.dcgAjax

  // Gallery filtering with AJAX
  $(".filter-btn").on("click", function () {
    const $btn = $(this)
    const category = $btn.data("category")

    // Update active state
    $(".filter-btn").removeClass("active")
    $btn.addClass("active")

    // Show loading state
    $("#gallery-grid").html('<div class="loading">Loading projects...</div>')

    // AJAX request
    $.ajax({
      url: dcgAjax.ajaxurl,
      type: "POST",
      data: {
        action: "dcg_filter_projects",
        category: category,
        nonce: dcgAjax.nonce,
      },
      success: (response) => {
        $("#gallery-grid").html(response)
        initGalleryItems()
      },
      error: () => {
        $("#gallery-grid").html('<p class="no-results">Error loading projects. Please try again.</p>')
      },
    })
  })

  // Initialize gallery item click handlers
  function initGalleryItems() {
    $(".gallery-item")
      .off("click")
      .on("click", function () {
        const postId = $(this).data("post-id")
        openModal(postId)
      })
  }

  // Open modal with project details
  function openModal(postId) {
    const $modal = $("#codeModal")
    const $modalBody = $("#modalBody")

    // Show modal with loading state
    $modal.addClass("active")
    $modalBody.html('<div class="loading">Loading project details...</div>')

    // AJAX request for project details
    $.ajax({
      url: dcgAjax.ajaxurl,
      type: "POST",
      data: {
        action: "dcg_get_project_details",
        post_id: postId,
        nonce: dcgAjax.nonce,
      },
      success: (response) => {
        if (response.success) {
          const data = response.data
          $("#modalTitle").text(data.title)

          let modalContent = ""

          if (data.thumbnail) {
            modalContent += `<img src="${data.thumbnail}" alt="${data.title}" style="width: 100%; border-radius: 8px; margin-bottom: 2rem;">`
          }

          modalContent += `<div style="margin-bottom: 2rem;">${data.content}</div>`

          if (data.code_snippet) {
            modalContent += `
                            <div style="margin-bottom: 2rem;">
                                <h3 style="margin-bottom: 1rem;">Code Snippet</h3>
                                <div class="code-preview">
                                    <pre><code>${escapeHtml(data.code_snippet)}</code></pre>
                                </div>
                            </div>
                        `
          }

          if (data.languages && data.languages.length > 0) {
            modalContent += `
                            <div style="margin-bottom: 1rem;">
                                <strong>Languages:</strong> ${data.languages.join(", ")}
                            </div>
                        `
          }

          if (data.difficulty) {
            modalContent += `
                            <div style="margin-bottom: 1rem;">
                                <strong>Difficulty:</strong> ${capitalizeFirst(data.difficulty)}
                            </div>
                        `
          }

          if (data.demo_url || data.github_url) {
            modalContent += '<div style="display: flex; gap: 1rem; margin-top: 2rem;">'

            if (data.demo_url) {
              modalContent += `
                                <a href="${data.demo_url}" target="_blank" rel="noopener" 
                                   style="padding: 0.75rem 1.5rem; background: var(--primary-color); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                                    View Live Demo
                                </a>
                            `
            }

            if (data.github_url) {
              modalContent += `
                                <a href="${data.github_url}" target="_blank" rel="noopener"
                                   style="padding: 0.75rem 1.5rem; background: var(--card-bg); color: var(--text-primary); text-decoration: none; border-radius: 8px; font-weight: 600; border: 2px solid var(--border-color);">
                                    View on GitHub
                                </a>
                            `
            }

            modalContent += "</div>"
          }

          $modalBody.html(modalContent)
        } else {
          $modalBody.html("<p>Error loading project details.</p>")
        }
      },
      error: () => {
        $modalBody.html("<p>Error loading project details. Please try again.</p>")
      },
    })
  }

  // Close modal
  $("#modalClose, #codeModal").on("click", function (e) {
    if (e.target === this) {
      $("#codeModal").removeClass("active")
    }
  })

  // Prevent modal content clicks from closing modal
  $(".modal-content").on("click", (e) => {
    e.stopPropagation()
  })

  // Escape key to close modal
  $(document).on("keydown", (e) => {
    if (e.key === "Escape") {
      $("#codeModal").removeClass("active")
    }
  })

  // Helper functions
  function escapeHtml(text) {
    const map = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': "&quot;",
      "'": "&#039;",
    }
    return text.replace(/[&<>"']/g, (m) => map[m])
  }

  function capitalizeFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
  }

  // Initialize on page load
  initGalleryItems()

  // Smooth scroll for anchor links
  $('a[href^="#"]').on("click", function (e) {
    const target = $(this.getAttribute("href"))
    if (target.length) {
      e.preventDefault()
      $("html, body")
        .stop()
        .animate(
          {
            scrollTop: target.offset().top - 100,
          },
          600,
        )
    }
  })
})(window.jQuery)
