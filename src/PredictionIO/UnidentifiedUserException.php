<?php

namespace PredictionIO;

/**
 * Thrown when user-related commands are called before identify() is called.
 */
class UnidentifiedUserException extends \Exception
{

}
