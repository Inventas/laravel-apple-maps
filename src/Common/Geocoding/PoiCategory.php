<?php

namespace Inventas\AppleMaps\Common\Geocoding;

enum PoiCategory: string
{
    /**
     * An airport.
     */
    case Airport = 'Airport';

    /**
     * A specific gate at an airport.
     */
    case AirportGate = 'AirportGate';

    /**
     * A specific named terminal at an airport.
     */
    case AirportTerminal = 'AirportTerminal';

    /**
     * An amusement park.
     */
    case AmusementPark = 'AmusementPark';

    /**
     * An Automated Teller Machine.
     */
    case ATM = 'ATM';

    /**
     * An Aquarium.
     */
    case Aquarium = 'Aquarium';

    /**
     * A bakery.
     */
    case Bakery = 'Bakery';

    /**
     * A bank.
     */
    case Bank = 'Bank';

    /**
     * A beach.
     */
    case Beach = 'Beach';

    /**
     * A brewery.
     */
    case Brewery = 'Brewery';

    /**
     * A Cafe.
     */
    case Cafe = 'Cafe';

    /**
     * A Campground.
     */
    case Campground = 'Campground';

    /**
     * A Car Rental Location.
     */
    case CarRental = 'CarRental';

    /**
     * A Electric Vehicle (EV) Charger/
     */
    case EVCharger = 'EVCharger';

    /**
     * A fire station.
     */
    case FireStation = 'FireStation';

    /**
     * A fitness center.
     */
    case FitnessCenter = 'FitnessCenter';

    /**
     * A food market.
     */
    case FoodMarket = 'FoodMarket';

    /**
     * A gas station.
     */
    case GasStation = 'GasStation';

    /**
     * A hospital.
     */
    case Hospital = 'Hospital';

    /**
     * A hotel.
     */
    case Hotel = 'Hotel';

    /**
     * A laundry.
     */
    case Laundry = 'Laundry';

    /**
     * A library.
     */
    case Library = 'Library';

    /**
     * A marina.
     */
    case Marina = 'Marina';

    /**
     * A movie theater.
     */
    case MovieTheater = 'MovieTheater';

    /**
     * A Museum.
     */
    case Museum = 'Museum';

    /**
     * A national park.
     */
    case NationalPark = 'NationalPark';

    /**
     * A night life venue.
     */
    case Nightlife = 'Nightlife';

    /**
     * A park.
     */
    case Park = 'Park';

    /**
     * A parking location for an automobile.
     */
    case Parking = 'Parking';

    /**
     * A pharmacy.
     */
    case Pharmacy = 'Pharmacy';

    /**
     * A playground.
     */
    case Playground = 'Playground';

    /**
     * A police station.
     */
    case Police = 'Police';

    /**
     * A post office.
     */
    case PostOffice = 'PostOffice';

    /**
     * A public transportation station.
     */
    case PublicTransport = 'PublicTransport';

    /**
     * A religious site.
     */
    case ReligiousSite = 'ReligiousSite';

    /**
     * A restaurant.
     */
    case Restaurant = 'Restaurant';

    /**
     * A restroom.
     */
    case Restroom = 'Restroom';

    /**
     * A school.
     */
    case School = 'School';

    /**
     * A stadium.
     */
    case Stadium = 'Stadium';

    /**
     * A store.
     */
    case Store = 'Store';

    /**
     * A theater.
     */
    case Theater = 'Theater';

    /**
     * A university.
     */
    case University = 'University';

    /**
     * A winery.
     */
    case Winery = 'Winery';

    /**
     * A zoo.
     */
    case Zoo = 'Zoo';
}
