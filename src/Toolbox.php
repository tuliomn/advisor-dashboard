<?php

namespace smtech\AdvisorDashboard;

use smtech\LTI\Configuration\Option;
use Battis\DataUtilities;

/**
 * Advisor Dashboard toolbox
 *
 * Adds some common, useful methods to the St. Mark's-styled
 * ReflexiveCanvasLTI Toolbox
 *
 * @author  Seth Battis <SethBattis@stmarksschool.org>
 * @version v1.2
 */
class Toolbox extends \smtech\StMarksReflexiveCanvasLTI\Toolbox
{

    /**
     * Configure course and account navigation placements
     *
     * @return Generator
     */
    public function getGenerator()
    {
        parent::getGenerator();

        $this->generator->setOptionProperty(
            Option::COURSE_NAVIGATION(),
            'visibility',
            'admins'
        );
        $this->generator->setOptionProperty(
            Option::ACCOUNT_NAVIGATION(),
            'visibility',
            'admins'
        );

        return $this->generator;
    }

    /**
     * Get a listing of all accounts organized for presentation in a select picker
     *
     * @return array
     **/
    function getAccountList()
    {
        $base = $this->getCache()->getBase();
        while ($this->cache_popKey()) {
            /* twiddle our fingers */
        }
        $this->cache_pushKey(basename(Toolbox::class));

        $accounts = $this->cache_get('accounts');
        if ($accounts === false) {
            $accountsResponse = $this->get(
                'accounts/1/sub_accounts',
                [
                    'recursive' => 'true'
                ]
            );
            $accounts = [];
            foreach ($accountsResponse as $account) {
                $accounts[$account['id']] = $account;
            }
            $this->cache_set('accounts', $accounts);
        }

        $this->cache_popKey();
        $this->cache_pushKey($base);

        return $accounts;
    }

    /**
     * Get a listing of all terms organized for presentation in a select picker
     *
     * @return array
     **/
    function getTermList()
    {
        $base = $this->getCache()->getBase();
        while ($this->cache_popKey()) {
            /* do nothing */
        }
        $this->cache_pushKey(basename(Toolbox::class));

        $terms = $cache->getCache('terms');
        if ($terms === false) {
            $_terms = $this->get(
                'accounts/1/terms',
                [
                    'workflow_state' => 'active'
                ]
            );
            $termsResponse = $_terms['enrollment_terms'];
            $terms = [];
            foreach ($termsResponse as $term) {
                $terms[$term['id']] = $term;
            }
            $this->cache_set('terms', $terms);
        }

        $this->cache_popKey();
        $this->cache_pushKey($base);

        return $terms;
    }
}
