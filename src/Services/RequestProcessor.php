<?php
namespace NeuroBro\Services;

use NeuroBro\Contracts\AIModel;
use NeuroBro\Contracts\AIRequest;
use NeuroBro\Exceptions\{LimitExceededException, UnsupportedFeatureException};

class RequestProcessor
{
    public function processRequest(AIModel $model, AIRequest $request): array
    {
        // Проверяем поддержку файлов, если они есть в запросе
        if ($request->getAttachments()) {
            if (!$model->isSupportedAttachments()) {
                throw new UnsupportedFeatureException(
                    "Model {$model->getName()} doesn't support file attachments"
                );
            }

            foreach ($request->getAttachments() as $attachment) {
                if (!in_array($attachment['type'], $model->getSupportedFileTypes())) {
                    throw new UnsupportedFeatureException(
                        "Unsupported file type: {$attachment['type']}"
                    );
                }
            }
        }

        // Проверяем возможность обработки запроса моделью
        if (!$model->canProcess($request)) {
            throw new UnsupportedFeatureException(
                'Request cannot be processed by this model'
            );
        }

        // Проверяем текущие лимиты
        $limits = $model->getCurrentLimits($request->getApiKey());
        foreach ($limits->getData() as $limit) {
            if ($limit->getRemaining() <= 0) {
                throw new LimitExceededException(
                    "Rate limit exceeded. Reset in {$limit->getSeconds()} seconds"
                );
            }
        }

        // Обрабатываем запрос
        return $model->process($request);
    }
}