import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

window.Echo.private("admin.notifications")
    .listen(".order.placed", (e) => {
        console.log("New order placed:", e);
        const badge = document.getElementById("newOrdersCount");
        let count = parseInt(badge.innerText) || 0;
        badge.innerText = count + 1;

        // Add to dropdown
        addAdminNotification(
            `🛒 New order #${e.id} by ${e.user} — $${e.total}`
        );
    })
    .listen(".review.submitted", (e) => {
        console.log("New review placed:", e);
        const badge = document.getElementById("newReviewsCount");
        let count = parseInt(badge.innerText) || 0;
        badge.innerText = count + 1;

        // Add to dropdown
        addAdminNotification(
            `⭐ ${e.rating}★ review on ${e.product} by ${e.user}: "${e.review}"`
        );
    });

function addAdminNotification(text) {
    const list = document.getElementById("notificationsList");

    // Create item
    const item = document.createElement("li");
    item.innerHTML = `<a href="#" class="dropdown-item text-wrap">${text}</a>`;

    // Insert new notification right after header
    list.insertBefore(item, list.children[2]);
}

document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.getElementById("notificationsDropdown");

    if (dropdown) {
        dropdown.addEventListener("click", function () {
            fetch(('/notifications/mark-as-read'), {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json",
                },
            }).then(() => {
                // document.getElementById("newOrdersCount").innerText = 0;
                console.log('Notifications marked as read');
                const badge = document.getElementById("newOrdersCount");
                if (badge) {
                    badge.remove();
                }

            });
        });
    }
});

