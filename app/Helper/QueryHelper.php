<?php

namespace App\Helper;

/**
 * Query Helper for filtering and sorting
 */
class QueryHelper
{
    /**
     * Apply filters to query
     */
    public static function applyFilters($query, $request, $filterableFields = [])
    {
        foreach ($filterableFields as $field) {
            if ($request->has($field) && $request->get($field) !== null && $request->get($field) !== '') {
                $query->where($field, $request->get($field));
            }
        }
        
        return $query;
    }

    /**
     * Apply search to query
     */
    public static function applySearch($query, $request, $searchableFields = [])
    {
        $search = $request->get('search') ?? $request->get('q');
        
        if ($search && !empty($searchableFields)) {
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', '%' . $search . '%');
                }
            });
        }
        
        return $query;
    }

    /**
     * Apply sorting to query
     */
    public static function applySort($query, $request, $defaultSort = 'created_at', $defaultOrder = 'desc')
    {
        $sortBy = $request->get('sort_by', $defaultSort);
        $sortOrder = $request->get('sort_order', $defaultOrder);
        
        // Validate sort order
        if (!in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }
        
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Apply date range filter
     */
    public static function applyDateRange($query, $request, $column = 'created_at')
    {
        if ($request->has('start_date') && $request->get('start_date')) {
            $query->whereDate($column, '>=', $request->get('start_date'));
        }
        
        if ($request->has('end_date') && $request->get('end_date')) {
            $query->whereDate($column, '<=', $request->get('end_date'));
        }
        
        return $query;
    }
}
