<?php

declare(strict_types=1);

namespace NunoMazer\Addressable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rinvex\Support\Traits\ValidatingTrait;
use Jackpopp\GeoDistance\GeoDistanceTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * NunoMazer\Addressable\Models\Address.
 *
 * @property int                                                $id
 * @property int                                                $addressable_id
 * @property string                                             $addressable_type
 * @property string                                             $label
 * @property string                                             $organization
 * @property string                                             $country_code
 * @property string                                             $state
 * @property string                                             $city
 * @property string                                             $district
 * @property string                                             $line_1
 * @property string                                             $line_2
 * @property string                                             $number
 * @property string                                             $complement
 * @property string                                             $postal_code
 * @property array                                              $extra
 * @property float                                              $latitude
 * @property float                                              $longitude
 * @property bool                                               $is_primary
 * @property bool                                               $is_billing
 * @property bool                                               $is_shipping
 * @property \Carbon\Carbon|null                                $created_at
 * @property \Carbon\Carbon|null                                $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $addressable
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address inCountry($countryCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address inLanguage($languageCode)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address isBilling()
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address isPrimary()
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address isShipping()
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address outside($distance, $measurement = null, $latitude = null, $longitude = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereComplement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereIsBilling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereIsPrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereIsShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereOrganization($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\NunoMazer\Addressable\Models\Address within($distance, $measurement = null, $latitude = null, $longitude = null)
 * @mixin \Eloquent
 */
class Address extends Model
{
    use ValidatingTrait;
    use GeoDistanceTrait;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'label',
        'organization',
        'country_code',
        'state',
        'city',
        'district',
        'line_1',
        'line_2',
        'number',
        'complement',
        'postal_code',
        'extra',
        'latitude',
        'longitude',
        'is_primary',
        'is_billing',
        'is_shipping',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'addressable_id' => 'integer',
        'addressable_type' => 'string',
        'label' => 'string',
        'organization' => 'string',
        'country_code' => 'string',
        'state' => 'string',
        'city' => 'string',
        'line_1' => 'string',
        'line_2' => 'string',
        'number' => 'string',
        'complement' => 'string',
        'postal_code' => 'string',
        'extra' => 'array',
        'latitude' => 'float',
        'longitude' => 'float',
        'is_primary' => 'boolean',
        'is_billing' => 'boolean',
        'is_shipping' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'addressable_id' => 'required|integer',
        'addressable_type' => 'required|string|strip_tags|max:150',
        'label' => 'nullable|string|strip_tags|max:150',
        'organization' => 'nullable|string|strip_tags|max:150',
        'country_code' => 'nullable|alpha|size:2|country',
        'state' => 'nullable|string|strip_tags|max:150',
        'city' => 'nullable|string|strip_tags|max:150',
        'district' => 'nullable|string|strip_tags|max:150',
        'line_1' => 'nullable|string|strip_tags|max:255',
        'line_2' => 'nullable|string|strip_tags|max:255',
        'number' => 'nullable|string|strip_tags|max:150',
        'complement' => 'nullable|string|strip_tags|max:150',
        'postal_code' => 'nullable|string|strip_tags|max:150',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'is_primary' => 'sometimes|boolean',
        'is_billing' => 'sometimes|boolean',
        'is_shipping' => 'sometimes|boolean',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('addressable.tables.addresses'));
    }

    /**
     * Get the owner model of the address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('addressable', 'addressable_type', 'addressable_id', 'id');
    }

    /**
     * Scope primary addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPrimary(Builder $builder): Builder
    {
        return $builder->where('is_primary', true);
    }

    /**
     * Scope billing addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsBilling(Builder $builder): Builder
    {
        return $builder->where('is_billing', true);
    }

    /**
     * Scope shipping addresses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsShipping(Builder $builder): Builder
    {
        return $builder->where('is_shipping', true);
    }

    /**
     * Scope addresses by the given country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $countryCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCountry(Builder $builder, string $countryCode): Builder
    {
        return $builder->where('country_code', $countryCode);
    }

    /**
     * Scope addresses by the given language.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param string                                $languageCode
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInLanguage(Builder $builder, string $languageCode): Builder
    {
        return $builder->where('language_code', $languageCode);
    }

    /**
     * {@inheritdoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $address) {
            if (config('addressable.addresses.geocoding')) {
                $segments[] = $address->line_1 . ' - ' . $address->number;
                $segments[] = sprintf('%s, %s %s', $address->city, $address->state, $address->postal_code);
                $segments[] = country($address->country_code)->getName();

                $query = str_replace(' ', '+', implode(', ', $segments));
                $geocode = json_decode(file_get_contents("https://maps.google.com/maps/api/geocode/json?address={$query}&sensor=false"));

                if (count($geocode->results)) {
                    $address->latitude = $geocode->results[0]->geometry->location->lat;
                    $address->longitude = $geocode->results[0]->geometry->location->lng;
                }
            }
        });
    }
}
