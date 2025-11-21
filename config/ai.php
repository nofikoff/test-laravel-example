<?php

/** @return array<string, string> */
return [
    'actor_extraction_prompt' => 'Extract actor information from the user description. Return JSON with fields: firstName, lastName, address, height, weight, gender, age. If a field is not mentioned in the description, set it to null. firstName, lastName, and address are REQUIRED fields.',
];
