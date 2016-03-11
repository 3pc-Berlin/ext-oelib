<?php
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * This class represents a country.
 *
 *
 * @author Niels Pardon <mail@niels-pardon.de>
 */
class Tx_Oelib_Model_Country extends Tx_Oelib_Model
{
    /**
     * @var bool whether this model is read-only
     */
    protected $readOnly = true;

    /**
     * Returns the country's local short name.
     *
     * @return string the country's local short name, will not be empty
     */
    public function getLocalShortName()
    {
        return $this->getAsString('cn_short_local');
    }

    /**
     * Returns the ISO 3166-1 alpha-2 code for this country.
     *
     * @return string the ISO 3166-1 alpha-2 code of this country, will not be empty
     */
    public function getIsoAlpha2Code()
    {
        return $this->getAsString('cn_iso_2');
    }

    /**
     * Returns the ISO 3166-1 alpha-3 code for this country.
     *
     * @return string the ISO 3166-1 alpha-3 code of this country, will not be empty
     */
    public function getIsoAlpha3Code()
    {
        return $this->getAsString('cn_iso_3');
    }
}
