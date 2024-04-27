<!-- Database Connection Check Modal -->
<div id="dbConnectionModal" class="modal" style="display:none;">
    <!-- Modal content container -->
    <div class="modal-content">
        <!-- Paragraph to display the database connection status -->
        <p id="dbConnectionStatus">Checking database connection...</p>
        <!-- Placeholder for status icon  -->
        <div id="connectionStatusIcon"></div>
        <!-- Continue button (hidden by default, shown when the database connection is successful) -->
        <button id="continueBtn" style="display:none;" class="button confirm">Continue</button>
        <!-- Retry button (hidden by default, shown when the database connection fails) -->
        <button id="retryBtn" style="display:none;" class="button cancel">Retry</button>
    </div>
</div>