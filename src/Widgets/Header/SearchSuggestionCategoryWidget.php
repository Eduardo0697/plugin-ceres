<?php

namespace Ceres\Widgets\Header;

use Ceres\Widgets\Helper\BaseWidget;
use Ceres\Widgets\Helper\Factories\WidgetSettingsFactory;
use Ceres\Widgets\Helper\WidgetCategories;
use Ceres\Widgets\Helper\Factories\WidgetDataFactory;
use Ceres\Widgets\Helper\WidgetTypes;

class SearchSuggestionCategoryWidget extends BaseWidget
{
    protected $template = "Ceres::Widgets.Header.SearchSuggestionCategoryWidget";

    public function getData()
    {
        return WidgetDataFactory::make("Ceres::SearchSuggestionCategoryWidget")
            ->withLabel("Widget.searchSuggestionCategoryLabel")
            ->withPreviewImageUrl("/images/widgets/search-suggestion-category.svg")
            ->withType(WidgetTypes::ITEM_SEARCH)
            ->withCategory(WidgetCategories::HEADER)
            ->withPosition(200)
            ->toArray();
    }

    public function getSettings()
    {
        /** @var WidgetSettingsFactory $settingsFactory */
        $settingsFactory = pluginApp(WidgetSettingsFactory::class);

        $settingsFactory->createCustomClass();

        $settingsFactory->createAppearance(true);

        $settingsFactory->createSpacing();

        return $settingsFactory->toArray();
    }
}
