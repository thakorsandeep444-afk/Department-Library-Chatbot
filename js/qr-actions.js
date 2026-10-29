// QR code actions: Download, Share and Print.
// This file builds its own buttons, so index.html only needs one <script> line.
(function () {
    "use strict";

    var SITE = "https://thakorsandeep444-afk.github.io/Department-Library-Chatbot/";
    var TITLE = "Department Library Chatbot";
    var TEXT = "Department Library Chatbot - K.D. Polytechnic, Patan. Scan the QR code or open: ";
    var MESSAGE = TEXT + SITE;

    function start() {
        var section = document.getElementById("qr-code");
        if (!section) return;

        var img = section.querySelector("img");
        if (!img) return;

        // Remove buttons from any earlier attempt, so nothing is added twice
        ["qr-actions", "qr-share-panel"].forEach(function (id) {
            var old = document.getElementById(id);
            if (old) old.remove();
        });

        // Small style block (so style.css does not need any change)
        var style = document.createElement("style");
        style.textContent =
            ".qr-actions{display:flex;justify-content:center;flex-wrap:wrap;gap:8px;margin-top:20px}" +
            ".qr-actions .btn{display:inline-flex;align-items:center;gap:4px}" +
            ".qr-actions .material-icons{font-size:18px}" +
            ".qr-share-panel{display:flex;justify-content:center;flex-wrap:wrap;gap:8px;margin-top:12px}" +
            ".qr-share-panel[hidden]{display:none}";
        document.head.appendChild(style);

        // Buttons
        var actions = document.createElement("div");
        actions.id = "qr-actions";
        actions.className = "qr-actions";
        actions.innerHTML =
            '<button type="button" id="qr-download-btn" class="btn btn-primary-custom"><span class="material-icons">download</span> Download</button>' +
            '<button type="button" id="qr-share-btn" class="btn btn-outline-custom"><span class="material-icons">share</span> Share</button>' +
            '<button type="button" id="qr-print-btn" class="btn btn-outline-custom"><span class="material-icons">print</span> Print</button>';

        // Fallback share options (shown when the phone share menu is not available)
        var panel = document.createElement("div");
        panel.id = "qr-share-panel";
        panel.className = "qr-share-panel";
        panel.hidden = true;
        panel.innerHTML =
            '<a target="_blank" rel="noopener" class="btn btn-sm btn-outline-custom" href="https://wa.me/?text=' + encodeURIComponent(MESSAGE) + '">WhatsApp</a>' +
            '<a target="_blank" rel="noopener" class="btn btn-sm btn-outline-custom" href="https://t.me/share/url?url=' + encodeURIComponent(SITE) + "&text=" + encodeURIComponent(TEXT) + '">Telegram</a>' +
            '<a class="btn btn-sm btn-outline-custom" href="mailto:?subject=' + encodeURIComponent(TITLE) + "&body=" + encodeURIComponent(MESSAGE) + '">Email</a>' +
            '<button type="button" id="qr-share-copy" class="btn btn-sm btn-outline-custom">Copy Link</button>';

        // Place them under the "Scan Here" text (or at the end of the card)
        var info = section.querySelector(".qr-info");
        var cardBody = section.querySelector(".card-body") || img.parentElement;
        if (info && info.parentNode) {
            info.insertAdjacentElement("afterend", panel);
            info.insertAdjacentElement("afterend", actions);
        } else {
            cardBody.appendChild(actions);
            cardBody.appendChild(panel);
        }

        // ---- Download ----
        document.getElementById("qr-download-btn").addEventListener("click", function () {
            var a = document.createElement("a");
            a.href = img.src;
            a.download = "department-library-chatbot-qr.png";
            document.body.appendChild(a);
            a.click();
            a.remove();
        });

        // ---- Share ----
        document.getElementById("qr-share-btn").addEventListener("click", async function () {
            try {
                if (navigator.share) {
                    try {
                        var blob = await (await fetch(img.src)).blob();
                        var file = new File([blob], "department-library-chatbot-qr.png", { type: blob.type || "image/png" });
                        if (navigator.canShare && navigator.canShare({ files: [file] })) {
                            await navigator.share({ files: [file], title: TITLE, text: MESSAGE });
                            return;
                        }
                    } catch (e) {
                        if (e && e.name === "AbortError") return;
                    }
                    await navigator.share({ title: TITLE, text: TEXT, url: SITE });
                    return;
                }
            } catch (e) {
                if (e && e.name === "AbortError") return;
            }
            panel.hidden = !panel.hidden;
        });

        // ---- Copy link ----
        document.getElementById("qr-share-copy").addEventListener("click", function () {
            var btn = this;
            var done = function () {
                btn.textContent = "Copied!";
                setTimeout(function () { btn.textContent = "Copy Link"; }, 1800);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(SITE).then(done);
            } else {
                var t = document.createElement("textarea");
                t.value = SITE;
                document.body.appendChild(t);
                t.select();
                document.execCommand("copy");
                t.remove();
                done();
            }
        });

        // ---- Print ----
        document.getElementById("qr-print-btn").addEventListener("click", function () {
            var w = window.open("", "_blank", "width=600,height=800");
            if (!w) { alert("Please allow pop-ups to print the QR code."); return; }
            w.document.write(
                "<html><head><title>" + TITLE + " QR</title>" +
                "<style>body{font-family:Arial,sans-serif;text-align:center;padding:40px}" +
                "img{width:320px;height:320px;margin:20px 0}h2{margin:0}p{margin:4px 0;color:#475569}</style></head>" +
                "<body><h2>" + TITLE + "</h2><h3>Scan Here</h3>" +
                '<img src="' + img.src + '" alt="QR Code">' +
                "<p><b>K.D. Polytechnic, Patan</b></p><p>Computer Engineering Department</p>" +
                "<script>window.onload=function(){setTimeout(function(){window.print();},300);};<\/script>" +
                "</body></html>"
            );
            w.document.close();
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", start);
    } else {
        start();
    }
})();