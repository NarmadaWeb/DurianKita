<?php
/**
 * Forward Chaining Inference Engine
 *
 * Logic:
 * 1. Get selected symptom IDs from user.
 * 2. Get all rules from database.
 * 3. Group rules by disease.
 * 4. For each disease, check if all of its required symptoms are present in user's selected symptoms.
 * 5. If multiple diseases match, we could return all or the one with most symptoms.
 *    Usually, Forward Chaining in expert systems returns the first match or all matches.
 */

function perform_diagnosis($pdo, $selected_symptom_ids) {
    if (empty($selected_symptom_ids)) {
        return null;
    }

    // Fetch all rules
    $stmt = $pdo->query("SELECT disease_id, symptom_id FROM rules");
    $rules = $stmt->fetchAll();

    $disease_rules = [];
    foreach ($rules as $rule) {
        $disease_rules[$rule['disease_id']][] = $rule['symptom_id'];
    }

    $matches = [];

    foreach ($disease_rules as $disease_id => $required_symptoms) {
        // Check if all required symptoms for this disease are in the selected symptoms
        // Forward Chaining: If Gejala A AND Gejala B THEN Penyakit X
        $is_match = true;
        foreach ($required_symptoms as $req_s) {
            if (!in_array($req_s, $selected_symptom_ids)) {
                $is_match = false;
                break;
            }
        }

        if ($is_match) {
            $matches[] = [
                'disease_id' => $disease_id,
                'symptom_count' => count($required_symptoms)
            ];
        }
    }

    if (empty($matches)) {
        return null;
    }

    // Sort by symptom count descending to get the most specific match
    usort($matches, function($a, $b) {
        return $b['symptom_count'] <=> $a['symptom_count'];
    });

    return $matches[0]['disease_id'];
}
?>
