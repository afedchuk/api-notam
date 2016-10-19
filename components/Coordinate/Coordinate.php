<?php
namespace app\components\Coordinate;

use yii\base\InvalidParamException;
use app\components\Coordinate\CoordinateInterface;

/**
 * Coordinate class
 *
 */
class Coordinate implements CoordinateInterface
{
    /**
     * The latitude of the coordinate.
     *
     * @var double
     */
    protected $latitude;

    /**
     * The longitude of the coordinate.
     *
     * @var double
     */
    protected $longitude;

    /**
     * Set the latitude and the longitude of the coordinates into an selected ellipsoid.
     *
     * @param Address|array|string         $coordinates The coordinates.
     * @param Ellipsoid                    $ellipsoid   The selected ellipsoid (WGS84 by default).
     *
     * @throws InvalidArgumentException
     */
    public function __construct($coordinates)
    {
        $this->setFromString($coordinates);
    }

    /**
     * Normalizes a latitude to the (-90, 90) range.
     * Latitudes below -90.0 or above 90.0 degrees are capped, not wrapped.
     *
     * @param double $latitude The latitude to normalize
     *
     * @return double
     */
    public function normalizeLatitude($latitude)
    {
        return (double) max(-90, min(90, $latitude));
    }

   /**
     * Normalizes a longitude to the (-180, 180) range.
     * Longitudes below -180.0 or abode 180.0 degrees are wrapped.
     *
     * @param double $longitude The longitude to normalize
     *
     * @return double
     */
    public function normalizeLongitude($longitude)
    {
        if (180 === $longitude % 360) {
            return 180.0;
        }

        $mod       = fmod($longitude, 360);
        $longitude = $mod < -180 ? $mod + 360 : ($mod > 180 ? $mod - 360 : $mod);
        return (double) $longitude;
    }

    /**
     * Set the latitude.
     *
     * @param double $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $this->normalizeLatitude($latitude);
    }

    /**
     * Get the latitude.
     *
     * @return double
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set the longitude.
     *
     * @param double $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $this->normalizeLongitude($longitude);
    }

    /**
     * Get the longitude.
     *
     * @return double
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Creates a valid and acceptable geographic coordinates.
     *
     * @param string $coordinates
     *
     * @throws InvalidArgumentException
     */
    public function setFromString($coordinates)
    {
        if (!is_string($coordinates)) {
            throw new InvalidParamException('The given coordinates should be a string!');
        }
        try {
            $inDecimalDegree = $this->toDecimalDegrees($coordinates);
            $this->setLatitude($inDecimalDegree[0]);
            $this->setLongitude($inDecimalDegree[1]);
        } catch (InvalidParamException $e) {
            throw $e;
        }
    }

    /**
     * Converts a valid and acceptable geographic coordinates to decimal degrees coordinate.
     *
     * @param string $coordinates A valid and acceptable geographic coordinates.
     *
     * @return array An array of coordinate in decimal degree.
     *
     * @throws InvalidArgumentException
     */
    private function toDecimalDegrees($coordinates)
    {
        if (preg_match('/([0-9]{2})+([0-9]{2})+([0-9]{1,2})*([ns]{1})([0-9]{3})+([0-9]{2})+([0-9]{1,2})*([we]{1})$/i', 
            $coordinates, $match)) {
            $latitude  = $match[1] + ($match[2] * 60 + $match[3]) / 3600;
            $longitude = $match[5] + ($match[6] * 60 + $match[7]) / 3600;

            return array(
                'N' === strtoupper($match[4]) ? $latitude  : -$latitude,
                'E' === strtoupper($match[8]) ? $longitude : -$longitude
            );
        }

        throw new InvalidParamException(
            'It should be a valid and acceptable ways to write geographic coordinates!'
        );
    }
}
