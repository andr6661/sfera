import { ref } from 'vue'

// Глобальное состояние для отслеживания несохранённых изменений
const hasUnsavedChanges = ref(false)
const originalData = ref(null)

export function useUnsavedChanges() {
  
  // Сохранить оригинальные данные при открытии
  const setOriginalData = (data) => {
    originalData.value = JSON.parse(JSON.stringify(data))
    hasUnsavedChanges.value = false
  }
  
  // Проверить, есть ли изменения
  const checkChanges = (currentData) => {
    if (!originalData.value) return false
    const currentStr = JSON.stringify(currentData)
    const originalStr = JSON.stringify(originalData.value)
    hasUnsavedChanges.value = currentStr !== originalStr
    return hasUnsavedChanges.value
  }
  
  // Сбросить флаг после сохранения
  const resetChanges = () => {
    hasUnsavedChanges.value = false
  }
  
  // Получить статус
  const getHasUnsavedChanges = () => hasUnsavedChanges.value
  
  return {
    hasUnsavedChanges,
    setOriginalData,
    checkChanges,
    resetChanges,
    getHasUnsavedChanges
  }
}