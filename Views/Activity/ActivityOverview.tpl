<link href="/WebundMultimedia/Css/Activity/Activity.css" rel="stylesheet"/>

<canvas id="activityOverview" style="background: rgba(255,255,255,0.3)"></canvas>

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
