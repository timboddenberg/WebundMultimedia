<link href="/WebundMultimedia/Css/Activity/Activity.css" rel="stylesheet"/>
<link href="/WebundMultimedia/Css/Product/Product.css" rel="stylesheet"/>

<h1 class="headerText">
    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-graph-up headerLogo" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5z"/>
    </svg>
    Aktivitätslog
</h1>
<hr>
<br>
<canvas id="activityOverview" style="background: rgba(255,255,255,0.3); border-radius: 15px;"></canvas>
<br><br>
<div class="row activityFilters">
    <div class="col-md-3">

        <div class="row">
            <label>
                Art der Abfrage
                <select class="form-select" id="activityType">
                    <option>Produkte pro Bestellung</option>
                    <option>Bestellung pro Tag</option>
                    <option>Lagerbestand</option>
                </select>
            </label>
        </div>

        <div class="row">
            <label id="productSelection">
                Produktauswahl
                <select class="form-select" id="productSelect"></select>
            </label>
        </div>

    </div>

    <div class="col-md-3">
        <label for="range" class="form-label">Anzahl Ergebnisse
            <input type="range" class="form-range" min="0" max="20" step="1" id="range">
        </label>
        <div id="rangeValue"></div>
    </div>

    <div class="col-md-6">
        <div id="submitActivityRequest"></div>
    </div>
</div>

<script src="/WebundMultimedia/Js/Custom/ActivityLog.js"></script>
