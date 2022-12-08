<?php

declare(strict_types=1);

/*
 * Copyright Iain Cambridge 2020-2022.
 *
 * Use of this software is governed by the Business Source License included in the LICENSE file and at https://getparthenon.com/docs/next/license.
 *
 * Change Date: TBD ( 3 years after 2.1.0 release )
 *
 * On the date above, in accordance with the Business Source License, use of this software will be governed by the open source license specified in the LICENSE file.
 */

namespace Parthenon\Export;

class ExportRequest
{
    public function __construct(
        protected string $filename,
        protected string $exportFormat,
        protected string $dataProviderService,
        protected array $dataProviderParameters = [],
    ) {
    }

    public function getExportFormat(): string
    {
        return $this->exportFormat;
    }

    public function getDataProviderService(): string
    {
        return $this->dataProviderService;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getDataProviderParameters(): array
    {
        return $this->dataProviderParameters;
    }
}