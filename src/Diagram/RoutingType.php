<?php

namespace Kevincobain2000\LaravelERD\Diagram;

enum RoutingType: string
{
    case NORMAL = 'Normal';
    case ORTHOGONAL = 'Orthogonal';

    /** This one can be VERY slow in large diagrams. */
    case AVOIDS_NODES = 'AvoidsNodes';
}
