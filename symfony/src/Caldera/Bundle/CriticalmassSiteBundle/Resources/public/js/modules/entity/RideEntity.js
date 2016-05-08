define(['CriticalService', 'leaflet', 'MarkerEntity', 'leaflet-extramarkers', 'ModalButton', 'CloseModalButton', 'dateformat'], function(CriticalService) {
    RideEntity = function () {
        this._CriticalService = CriticalService;
    };

    RideEntity.prototype = new MarkerEntity();
    RideEntity.prototype.constructor = RideEntity;

    RideEntity.prototype._CriticalService = null;
    RideEntity.prototype._title = null;
    RideEntity.prototype._description = null;
    RideEntity.prototype._citySlug = null;
    RideEntity.prototype._location = null;
    RideEntity.prototype._timestamp = null;

    RideEntity.prototype._initIcon = function() {
        this._icon = L.ExtraMarkers.icon({
            icon: 'fa-bicycle',
            markerColor: 'red',
            shape: 'round',
            prefix: 'fa'
        });
    };

    RideEntity.prototype._setupModalContent = function () {
        this._modal.setTitle(this._title);

        var content = '<dl class="dl-horizontal">';

        content += '<dt>Datum:</dt><dd>' + this._timestamp.format('dd.mm.yyyy') + '</dd>';
        content += '<dt>Uhrzeit:</dt><dd>' + this._timestamp.format('HH:MM') + ' Uhr</dd>';
        content += '<dt>Treffpunkt:</dt><dd>' + this._location + '</dd>';

        if (this._weather) {
            content += '<dt>Wetter:</dt><dd>' + this._weather + '</dd>';
        }

        content += '</dl>';

        if (this._description) {
            content += '<p>' + this._description + '</p>';
        }

        this._modal.setBody(content);

        var that = this;

        var centerButton = new ModalButton();
        centerButton.setCaption('Zentrieren');
        centerButton.setIcon('map-pin');
        centerButton.setClass('btn-success');
        centerButton.setOnClickEvent(function() {
            that._CriticalService.getMap().setView([that._latitude, that._longitude], 13);
        });

        var cityButton = new ModalButton();
        cityButton.setCaption('Städteseite');
        cityButton.setIcon('university');
        cityButton.setClass('btn-success');
        cityButton.setHref(Routing.generate('caldera_criticalmass_desktop_city_show', { citySlug: this._city._slug }));

        var rideButton = new ModalButton();
        rideButton.setCaption('Tourseite');
        rideButton.setIcon('bicycle');
        rideButton.setClass('btn-success');
        rideButton.setHref(Routing.generate('caldera_criticalmass_ride_show', { citySlug: this._city._slug, rideDate: this._timestamp.format('yyyy-mm-dd') }));

        var closeButton = new CloseModalButton;

        var buttons = [
            cityButton,
            rideButton,
            centerButton,
            closeButton
        ];

        this._modal.setButtons(buttons);
    };

    RideEntity.prototype.getDate = function() {
        return this._date;
    };

    return RideEntity;
});